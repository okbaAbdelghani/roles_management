<?php

namespace App\Http\Controllers;

use App\Models\File;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UploadController extends Controller
{
    public function index(Request $request){
        //$files = File::with('user')->whereIn('status',['uploaded','ready','processing'])->orderBy('id','desc')->get()->toArray();
        $files = File::with('user')->orderBy('id','desc')->get()->toArray();
        return view('uploadFile',[
            "files"=>$files,
            "tables"=>$this->getTables(),
        ]);
    }
    public function uploadFile(Request $request) {
        if($request->hasFile('file')) {
            $extension = $request->file('file')->clientExtension();
            if ($extension !== "xlsx" && $extension !== "xls" && $extension !== "csv") {
                return redirect()->back()->with('error','File Type not supported, please upload an Excel file');
            }
        } else {
            return redirect()->back()->with('error','Please choose a file');
        }
        $fileModel = new File();
        $file = $request->file('file');
        $fileName = time().'_'.$request->file->getClientOriginalName();
        $filePath = $file->storeAs('uploads', $fileName);
        if ($filePath){
            $fileModel->name = $request->file->getClientOriginalName();
            $fileModel->file_path = $filePath;
            $fileModel->status = 'uploaded';
            $fileModel->size = $file->getSize();
            $fileModel->user_id = auth()->user()->id;
            $fileModel->save();
            return back()->with('success','File has been uploaded.');
        } else {
            return back()->with('error','An error has occurred');
        }

    }
    public function fileConf(Request $request, File $file) {
        if ($file){
            $validator = Validator::make($request->all(), ['table_name'=>'required']);
            if ($validator->fails()) {
                return redirect()->back()->with('error',$validator->messages()->first());
            }

            $tableName = $request->get("table_name");

            //check if file still exist
            if (!Storage::exists($file->file_path)) {
                return redirect()->back()->with('error',"File has been deleted");
            }

            //Get Columns names
            $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
            $typedColumns = [];

            if (!is_array($columns) || count($columns) === 0){
                return redirect()->back()->with('error',"Table not found or it's empty");
            } else {
                foreach ($columns as $key=>$column){
                    if (in_array($column,['id','uuid','created_at','updated_at'])) {
                        unset($columns[$key]);
                    } else {
                        $typedColumns[$column] = DB::getSchemaBuilder()->getColumnType($tableName,$column);
                    }
                }
            }
            $fileColumns = [];
            $nbOfRows = null;
            # open the file
            $reader = ReaderEntityFactory::createXLSXReader();
            $reader->open(Storage::path($file->file_path));
            # read each cell of each row of each sheet
            /** @var \Box\Spout\Reader\XLSX\Sheet $sheet */
            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $row) {
                    foreach ($row->getCells() as $cell) {
                        $fileColumns[] = $cell->getValue();
                    }
                    break;
                }
                break;
            }
            $reader->close();

            if (count($fileColumns) === 0){
                return redirect()->back()->with('error',"File is empty");
            }
            //Update the file
            $file->file_columns = $fileColumns;
            $file->table_name = $tableName;
            $file->save();
            // return the view with file Columns and cb table Columns
            return view('fileConf',[
                "file"=>$file,
                "rows"=>$nbOfRows,
                "columns"=>$typedColumns,
                "fileColumns"=>$fileColumns,
            ]);
        } else {
            return response()->status(404);
        }
    }
    public function filePostConf(Request $request, File $file){
        if ($file){
            $data = $request->all();
            //Remove unwanted Data
            foreach ($data as $key=>$value){
                if ( Str::startsWith($key,'_')){
                    unset($data[$key]);
                }
            }
            unset($data['erase_table']);
            $file->status = 'ready';
            $file->columns_in_table = $data;
            $file->erase_table = $request->get("erase_table") === 'on';
            $file->save();
            return redirect()->route('upload');
        } else {
            throw new NotFoundHttpException();
        }

    }

    private function getTables(){
       return [
            "test_table",
            "manuscripts",
        ];
    }
}
