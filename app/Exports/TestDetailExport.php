<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TestDetailExport implements FromView, ShouldAutoSize
{
    protected $data;
    protected $tanggalStart;
    protected $tanggalEnd;


    public function __construct($data, $tanggalStart, $tanggalEnd)
    {
        $this->data = $data;
        $this->tanggalStart = $tanggalStart;
        $this->tanggalEnd = $tanggalEnd;

        // dd($this->data);
    }

    public function view(): View
    {
        return view('dashboard.report.report_test_detail.excel', [
            'testDetails' => $this->data,
            'tanggalStart' => $this->tanggalStart,
            'tanggalEnd' => $this->tanggalEnd
        ]);
    }
}
