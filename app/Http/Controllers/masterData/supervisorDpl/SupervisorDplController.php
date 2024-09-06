<?php

namespace App\Http\Controllers\masterData\supervisorDpl;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupervisorDplController extends Controller
{
    public function index(Request $request)
    {
        $institusi = $request->institusi;
        if ($request->ajax()) {
            $data = Profile::orderBy('nama_lengkap', 'asc')
                ->where('institusi_id', $institusi)
                ->whereHas('user', function ($query) {
                    $query->where('role', 'Supervisor');
                })
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('total', function ($row) {
                    return $row->lokasiSurveySupervisor->count();
                })
                ->addColumn('lokasi_survey', function ($row) {
                    if ($row->lokasiSurveySupervisor) {
                        $daftarLokasi = '';
                        foreach ($row->lokasiSurveySupervisor as $lokasi) {
                            $daftarLokasi .= '<p class="my-0">-' . $lokasi->lokasiSurvey->nama_lokasi_survey . ', <span class="fw-bold">' . $lokasi->lokasiSurvey->desa_kelurahan->nama . '</span></p>';
                        }
                    } else {
                        $daftarLokasi = '-';
                    }
                    return $daftarLokasi;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <div class="row text-center justify-content-center">';
                    $actionBtn .= '
                            <a id="btn-edit" class="btn btn-success btn-sm mr-1 my-1" href="' . url('/lokasi-survey-supervisor-dpl' . "/" . $row->id) . '"><i class="far fa-eye"></i></a>
                        </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'total', 'lokasi_survey'])
                ->make(true);
        }
        return view('pages.masterData.supervisorDpl.supervisorDpl.index', compact(['institusi']));
    }
}
