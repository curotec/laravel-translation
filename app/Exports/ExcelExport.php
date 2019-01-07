<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Helpers\Utils;
use Storage;
use File;


class ExcelExport implements WithMultipleSheets
{
    use Exportable;

    protected $files;
    protected $path;
    protected $dpath;

    public function __construct($files,$path,$dpath)
    {
        $this->files = $files;
        $this->path=$path;
        $this->dpath=$dpath;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        if(!empty($this->files)){
          foreach($this->files as $file){
            if(Storage::exists($file)){
                if(File::extension($this->path.$file) == 'php'){
                      $myArray = include $this->path.$file;
                      $data=Utils::recursive_implode($myArray);
                      $sheets[] = new MultisheetdataExport($data, pathinfo($this->path.$file,PATHINFO_FILENAME));
                }
            }
          }
        }
        Storage::deleteDirectory($this->dpath);
        return $sheets;
    }
}
