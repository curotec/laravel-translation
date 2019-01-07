<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class MultisheetdataExport implements FromView, WithTitle
{
    private $data;
    private $filename;

    public function __construct($data,$filename){
        $this->data=$data;
        $this->filename=$filename;
    }

    public function view(): View
    {
        return view('exports.dataexport', [
            'data' => $this->data
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->filename;
    }
}
