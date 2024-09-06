<?php

namespace App\Http\Controllers\masterData\supervisorDpl;

use App\Http\Controllers\Controller;
use App\Models\Institusi;
use App\Models\Profile;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class InstitusiSupervisorDplController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Institusi::orderBy('nama', 'asc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('total', function ($row) {
                    $total = Profile::where('institusi_id', $row->id)->whereHas('user', function ($query) {
                        $query->where('role', 'Supervisor');
                    })->count();
                    return $total;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <div class="row text-center justify-content-center">';
                    $actionBtn .= '
                            <a class="btn btn-success btn-sm mr-1 my-1" href="' . url('/supervisor-dpl' . "/" . $row->id) . '"><i class="far fa-eye"></i></a>
                        </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'total'])
                ->make(true);
        }
        return view('pages.masterData.supervisorDpl.institusi.index');
    }
}
