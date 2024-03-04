<?php

namespace App\Exports;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class TATExport implements FromView, ShouldAutoSize
{
    protected $data;
  

    public function __construct($data)
    {
        $this->data = $data;
    

        // dd($this->testData);
    }

    public function view(): View
    {
        return view('dashboard.report.report_tat.excel', $this->data);
    }
}
