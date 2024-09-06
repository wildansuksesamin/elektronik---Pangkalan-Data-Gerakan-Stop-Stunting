<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SurveyExport implements FromView
{
    protected $kategori;
    protected $survey;
    protected $surveyor;
    protected $institusi;
    protected $supervisor;
    protected $halaman;

    function __construct($kategori, $survey, $surveyor, $institusi, $supervisor, $halaman)
    {
        $this->kategori = $kategori;
        $this->survey = $survey;
        $this->surveyor = $surveyor;
        $this->institusi = $institusi;
        $this->supervisor = $supervisor;
        $this->halaman = $halaman;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): view
    {
        $daftarKategori = $this->kategori;
        $daftarSurvey = $this->survey;
        $surveyor = $this->surveyor;
        $institusi = $this->institusi;
        $supervisor = $this->supervisor;
        $halaman = $this->halaman;
        return view('pages.survey.exportSurvey.export', compact('daftarKategori', 'daftarSurvey', 'surveyor', 'institusi', 'supervisor', 'halaman'));
    }
}
