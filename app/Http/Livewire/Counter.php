<?php

namespace App\Http\Livewire;

use App\Models\File;
use Livewire\Component;

class Counter extends Component
{
    public $count = 0;
    public $fileId;
    public function render(){
        $file = File::find($this->fileId);
        if ($file){
            $this->count = $file->progress;
        }
        return view('livewire.counter');
    }
}
