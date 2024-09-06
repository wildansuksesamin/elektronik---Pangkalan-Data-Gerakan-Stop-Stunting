<?php

namespace App\Http\Controllers\surveySupervisor;

use App\Http\Controllers\Controller;
use App\Models\KategoriSoal;
use App\Models\NamaSurvey;
use App\Models\Profile;
use App\Models\Survey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SurveySupervisorController extends Controller
{
    public function index(Request $request)
    {
        $namaSurvey = NamaSurvey::all();
        $lokasiSurveySupervisor = $request->lokasiSurveySupervisor;
        if ($request->ajax()) {
            $data = Survey::with(['responden', 'namaSurvey', 'profile', 'anggotaSupervisor'])->whereHas('anggotaSupervisor', function ($query) use ($lokasiSurveySupervisor) {
                $query->where('lokasi_survey_supervisor_id', $lokasiSurveySupervisor);
            })
                ->where(function ($query) use ($request) {
                    if ($request->nama_surveyor_id != 'semua' && $request->nama_surveyor_id != null) {
                        $query->where('profile_id', $request->nama_surveyor_id);
                    }
                    if ($request->nama_survey_id != 'semua' && $request->nama_survey_id != null) {
                        $query->where('nama_survey_id', $request->nama_survey_id);
                    }
                })
                ->where('is_selesai', 1)->orderBy('updated_at', 'DESC')
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    return '<h6 class="text-uppercase mb-1 mt-4">Surveyor: ' . $row->profile->nama_lengkap . '</h6>
                                    <h6 class="text-uppercase fw-bold mb-0">Responden: ' . $row->responden->kartu_keluarga . ' (' . $row->responden->nama_kepala_keluarga . ')</h6>
                                    <span class="text-muted mb-4">Judul:  ' . $row->namaSurvey->nama . '</span>';
                })
                ->addColumn('tipe', function ($row) {
                    if ($row->namaSurvey->tipe == "Pre") {
                        return '<span class="badge badge-primary">PRE</span>';
                    } else {
                        return '<span class="badge badge-success">POST</span>';
                    }
                })
                ->addColumn('status', function ($row) {
                    if ($row->is_selesai == "0") {
                        return '<span class="badge badge-warning">Belum Selesai</span>';
                    } else {
                        return '<span class="badge badge-success">Selesai</span>';
                    }
                })
                ->addColumn('tanggal', function ($row) {
                    return Carbon::parse($row->created_at)->translatedFormat('d F Y');
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . url('/survey/lihat-survey') . "/" . $row->kode_unik . '" class="btn btn-primary btn-sm mr-1 my-1" title="Ubah" target="_blank"><i class="fas fa-eye"></i> Lihat</a>';

                    return $actionBtn;
                })
                ->rawColumns(['nama', 'tipe', 'status', 'action'])
                ->make(true);
        }
        $listAnggotaSupervisor = Profile::with('anggotaSupervisor')
            ->whereHas('anggotaSupervisor', function ($query) use ($lokasiSurveySupervisor) {
                $query->where('lokasi_survey_supervisor_id', $lokasiSurveySupervisor);
            })
            ->whereHas('user', function ($query) {
                $query->where('role', '=', 'surveyor');
            })
            ->orderBy('nama_lengkap', 'asc')
            ->get();

        return view('pages.surveySupervisor.surveySupervisor.index', compact(['lokasiSurveySupervisor', 'listAnggotaSupervisor', 'namaSurvey']));
    }
}
