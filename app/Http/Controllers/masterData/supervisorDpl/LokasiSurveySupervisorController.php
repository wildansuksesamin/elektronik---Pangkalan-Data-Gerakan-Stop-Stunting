<?php

namespace App\Http\Controllers\masterData\supervisorDpl;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\AnggotaSupervisor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\LokasiSurveySupervisor;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class LokasiSurveySupervisorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dpl = $request->dpl;
        $profile = Profile::where('id', $dpl)->first();
        if (!$profile) {
            return redirect()->back();
        }

        if ($request->ajax()) {
            $data = LokasiSurveySupervisor::orderBy('created_at', 'desc')
                ->where('profile_id', $dpl)
                ->get();
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
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <div class="row text-center justify-content-center">';
                    $actionBtn .= '
                            <a id="btn-edit" class="btn btn-success btn-sm mr-1 my-1" href="' . url('/anggota-supervisor-dpl' . "/" . $row->id) . '"  onclick="edit(' . $row->id . ')"><i class="far fa-eye"></i></a>';
                    if (Auth::user()->role == 'Admin') {
                        $actionBtn .= '<button id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1" value="' . $row->id . '" ><i class="fas fa-edit"></i></button>';
                        $actionBtn .= ' <button id="btn-delete" class="btn btn-danger btn-sm mr-1 my-1" value="' . $row->id . '" > <i class="fas fa-trash-alt"></i></button>';
                    }
                    $actionBtn .= '</div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'total'])
                ->make(true);
        }
        return view('pages.masterData.supervisorDpl.lokasiSurvey.index', compact(['dpl', 'profile']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dpl = $request->dpl;
        $validator = Validator::make(
            $request->all(),
            [
                'lokasi_survey_id' => [
                    'required', Rule::unique('lokasi_survey_supervisor')
                        ->where(function ($query) use ($dpl) {
                            return $query->where('profile_id', $dpl);
                        })
                        ->withoutTrashed(),
                ],
            ],
            [
                'lokasi_survey_id.required' => 'Lokasi survey / posko tidak boleh kosong',
                'lokasi_survey_id.unique' => 'Lokasi survey / posko sudah ada',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $profileDpl = Profile::where('id', $dpl)->first();
        $lokasiSurveyDpl = LokasiSurveySupervisor::where('lokasi_survey_id', $request->lokasi_survey_id)
            ->whereHas('profile', function ($query) use ($profileDpl) {
                $query->where('institusi_id', $profileDpl->institusi_id);
            })
            ->first();

        if ($lokasiSurveyDpl) {
            return response()->json(
                [
                    'error' => [
                        'lokasi_survey_id' => [
                            'Lokasi survey / posko sudah ada di Supervisor / DPL lain'
                        ]
                    ]
                ]
            );
        }

        $lokasiSurvey = new LokasiSurveySupervisor();
        $lokasiSurvey->profile_id = $dpl;
        $lokasiSurvey->lokasi_survey_id = $request->lokasi_survey_id;
        $lokasiSurvey->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LokasiSurveySupervisor  $lokasiSurveySupervisor
     * @return \Illuminate\Http\Response
     */
    public function show(LokasiSurveySupervisor $lokasiSurveySupervisor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LokasiSurveySupervisor  $lokasiSurveySupervisor
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $lokasiSurveySupervisor = LokasiSurveySupervisor::where('id', $request->lokasiSurvey)->first();
        return response()->json($lokasiSurveySupervisor);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LokasiSurveySupervisor  $lokasiSurveySupervisor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $dpl = $request->dpl;
        $lokasiSurveySupervisor = $request->lokasiSurvey;
        $validator = Validator::make(
            $request->all(),
            [
                'lokasi_survey_id' => ['required', Rule::unique('lokasi_survey_supervisor')
                    ->ignore($lokasiSurveySupervisor)
                    ->where(function ($query) use ($dpl) {
                        return $query->where('profile_id', $dpl);
                    })
                    ->withoutTrashed()],
            ],
            [
                'lokasi_survey_id.required' => 'Lokasi survey / posko tidak boleh kosong',
                'lokasi_survey_id.unique' => 'Lokasi survey / posko sudah ada',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $profileDpl = Profile::where('id', $dpl)->first();
        $lokasiSurveyDpl = LokasiSurveySupervisor::where('lokasi_survey_id', $request->lokasi_survey_id)
            ->where('id', '!=', $lokasiSurveySupervisor)
            ->whereHas('profile', function ($query) use ($profileDpl) {
                $query->where('institusi_id', $profileDpl->institusi_id);
            })
            ->first();

        if ($lokasiSurveyDpl) {
            return response()->json(
                [
                    'error' => [
                        'lokasi_survey_id' => [
                            'Lokasi survey / posko sudah ada di Supervisor / DPL lain'
                        ]
                    ]
                ]
            );
        }

        $lokasiSurvey = LokasiSurveySupervisor::where('id', $lokasiSurveySupervisor)->first();
        $lokasiSurvey->profile_id = $dpl;
        $lokasiSurvey->lokasi_survey_id = $request->lokasi_survey_id;
        $lokasiSurvey->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LokasiSurveySupervisor  $lokasiSurveySupervisor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $lokasiSurveySupervisor = $request->lokasiSurvey;
        $lokasiSurvey = LokasiSurveySupervisor::where('id', $lokasiSurveySupervisor)->first();
        $lokasiSurvey->delete();

        $anggotaSupervisior = AnggotaSupervisor::where('lokasi_survey_supervisor_id', $lokasiSurvey->id)->delete();
        return response()->json(['status' => 'success']);
    }
}
