<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class RespondenExport implements FromView
{
    protected $responden;

    function __construct($responden)
    {
        $this->responden = $responden;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $daftarResponden = $this->responden;
        return view('pages.masterData.responden.export', compact(['daftarResponden']));
    }
}
