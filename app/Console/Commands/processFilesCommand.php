<?php

namespace App\Console\Commands;

use App\Models\File;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class processFilesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will import all files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       $maxToImport = 100000;
       $file = File::where('status','ready')
                    ->orderBy('id')
                    ->get()
                    ->first();
       if ($file){
           try {
               $currentDateTime = Carbon::now();
               //Change file status to processing
               $file->status = 'processing';
               $file->tries = $file->trie + 1;
               $file->start_at = $currentDateTime;
               $file->update();
               //Check if all required attributes are there
               if (empty($file->table_name)){
                   $file->status = 'failed';
                   $file->last_error = 'Table Name Not Found';
                   $file->update();
               }
               if (empty($file->columns_in_table)){
                   $file->status = 'failed';
                   $file->last_error = 'Corresponding Columns Not Found';
                   $file->update();
               }
               if ($file->erase_table){
                   DB::table($file->table_name)->truncate();
               }
               $counter = 0;
               $imported = 0;
               $fileColumns = [];
               //Start Processing the file
               # open the file
               $reader = ReaderEntityFactory::createXLSXReader();
               $reader->open(Storage::path($file->file_path));
               # read each cell of each row of each sheet
               /** @var \Box\Spout\Reader\XLSX\Sheet $sheet */
               foreach ($reader->getSheetIterator() as $sheet) {
                   foreach ($sheet->getRowIterator() as $row) {
                       if ($counter === 0){
                           $fileColumns = $row->toArray();
                       } else {
                           if ($counter < $file->progress){
                               $counter++;
                               continue;
                           } else {
                               $rowData = $row->toArray();
                               for ( $i=0 ; $i<count($fileColumns) ; $i++ ){
                                   $data[$fileColumns[$i]] = $rowData[$i] ?? '';
                               }
                               //Insert The Data
                               $res = $this->insertDataIntoTable($file, $data);
                               if ($res){
                                   $file->progress++;
                                   $file->update();
                               }
                           }
                       }
                       $counter++;
                   }
                   break;
               }
               $reader->close();
               //$file->progress += $imported;
               $file->status = 'imported';
               $file->update();
           } catch (\Exception $e){
               $file->status = 'failed';
               $file->last_error = $e->getMessage();
               $file->update();
           }

       }
    }

    private function insertDataIntoTable($file, $data): bool
    {
        $dataToInsert = [];
        //Prepare Data
        foreach ($file->columns_in_table as $key=>$value) {
            if ($value !== 'ignore'){
                $dataToInsert[$key] = empty($data[$value]) ? null : $data[$value];
            }
        }
        $dataToInsert["uuid"] = Str::uuid();
        //Insert Data
        return DB::table($file->table_name)->insert($dataToInsert);

    }
}
