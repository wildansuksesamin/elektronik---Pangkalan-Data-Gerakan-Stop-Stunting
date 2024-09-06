<?php

namespace App\Http\Controllers\surveySupervisor;

use App\Http\Controllers\Controller;
use App\Models\LokasiSurveySupervisor;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SurveySupervisorLokasiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LokasiSurveySupervisor::orderBy('created_at', 'desc')
                ->where('profile_id', Auth::user()->profile->id)
                ->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    return $row->lokasiSurvey->nama_lokasi_survey;
                })
                ->addColumn('wilayah', function ($row) {
                    return $row->lokasiSurvey->desa_kelurahan->nama . ", " . $row->lokasiSurvey->desa_kelurahan->kecamatan->nama . ", " . $row->lokasiSurvey->desa_kelurahan->kecamatan->kabupatenKota->nama . ", " . $row->lokasiSurvey->desa_kelurahan->kecamatan->kabupatenKota->provinsi->nama;
                })
                ->addColumn('total', function ($row) {
                    return $row->anggotaSupervisor->count();
                })
                ->addColumn('total_data', function ($row) {
                    return Survey::with('anggotaSupervisor')->whereHas('anggotaSupervisor', function ($query) use ($row) {
                        $query->where('profile_dpl', Auth::user()->profile->id);
                        $query->where('lokasi_survey_supervisor_id', $row->id);
                    })->where('is_selesai', 1)->count();
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <div class="row text-center justify-content-center">';
                    $actionBtn .= '
                            <a id="btn-edit" class="btn btn-success btn-sm mr-1 my-1" href="' . url('/survey-supervisor/survey' . "/" . $row->id) . '"  onclick="edit(' . $row->id . ')"><i class="far fa-eye"></i></a>
                        </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'total'])
                ->make(true);
        }
        return view('pages.surveySupervisor.lokasiSurvey.index');
    }
}
