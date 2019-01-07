<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;

// Überschriften werden genau so übernommen wie sie in der Datei angegeben wurden
HeadingRowFormatter::default('none');

class DataImport implements ToArray, WithHeadingRow, WithEvents
{

    public $sheetNames;
    public $sheetData;

    public function __construct(){
        $this->sheetNames = [];
	       $this->sheetData = [];
    }
    public function array(array $array)
    {
    	$this->sheetData[] = $array;
    }
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
            	$this->sheetNames[] = $event->getSheet()->getTitle();
            }
        ];
    }

}
