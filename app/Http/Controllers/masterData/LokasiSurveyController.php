<?php

namespace App\Http\Controllers\masterData;

use App\Models\Responden;
use App\Models\LokasiSurvey;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class LokasiSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LokasiSurvey::with('desa_kelurahan')->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('desa_kelurahan', function ($row) {
                    return $row->desa_kelurahan->nama;
                })
                ->addColumn('kecamatan', function ($row) {
                    return $row->desa_kelurahan->kecamatan->nama;
                })
                ->addColumn('kabupaten_kota', function ($row) {
                    return $row->desa_kelurahan->kecamatan->kabupatenKota->nama;
                })
                ->addColumn('provinsi', function ($row) {
                    return $row->desa_kelurahan->kecamatan->kabupatenKota->provinsi->nama;
                })
                ->addColumn('action', function ($row) {
                    if (Auth::user()->role == "Admin") {
                        $actionBtn = '
                <div class="row text-center justify-content-center">';
                        $actionBtn .= '
                    <a href="' . route('lokasi-survey.edit', $row->id) . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>
                    <button id="btn-delete" class="btn btn-danger btn-sm mr-1 my-1 btn-delete" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>
                </div>';
                    } else {
                        $actionBtn = '-';
                    }

                    return $actionBtn;
                })
                ->filter(function ($query) use ($request) {
                    if ($request->search != '') {
                        $query->where(function ($query) use ($request) {
                            $query->where("nama_lokasi_survey", "LIKE", "%$request->search%");
                        });
                    }

                    if (!empty($request->provinsi)) {
                        $query->whereHas('desa_kelurahan', function ($query) use ($request) {
                            $query->whereHas('kecamatan', function ($query) use ($request) {
                                $query->whereHas('kabupatenKota', function ($query) use ($request) {
                                    $query->whereHas('provinsi', function ($query) use ($request) {
                                        $query->where('id', $request->provinsi);
                                    });
                                });
                            });
                        });
                    }

                    if (!empty($request->kabupaten)) {
                        $query->whereHas('desa_kelurahan', function ($query) use ($request) {
                            $query->whereHas('kecamatan', function ($query) use ($request) {
                                $query->whereHas('kabupatenKota', function ($query) use ($request) {
                                    $query->where('id', $request->kabupaten);
                                });
                            });
                        });
                    }

                    if (!empty($request->kecamatan)) {
                        $query->whereHas('desa_kelurahan', function ($query) use ($request) {
                            $query->whereHas('kecamatan', function ($query) use ($request) {
                                $query->where('id', $request->kecamatan);
                            });
                        });
                    }

                    if (!empty($request->desa)) {
                        $query->whereHas('desa_kelurahan', function ($query) use ($request) {
                            $query->where('id', $request->desa);
                        });
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.masterData.lokasiSurvey.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.masterData.lokasiSurvey.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLokasiSurveyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_lokasi_survey' => ['required', Rule::unique('lokasi_survey')->withoutTrashed()],
                'provinsi' => 'required',
                'kabupaten_kota' => 'required',
                'kecamatan' => 'required',
                'desa_kelurahan' => 'required',

            ],
            [
                'nama_lokasi_survey.required' => 'Nama Lokasi Survey / Posko tidak boleh kosong',
                'nama_lokasi_survey.unique' => 'Kartu Lokasi Survey / Posko sudah terdaftar',
                'provinsi.required' => 'Provinsi tidak boleh kosong',
                'kabupaten_kota.required' => 'Kabupaten/Kota tidak boleh kosong',
                'kecamatan.required' => 'Kecamatan tidak boleh kosong',
                'desa_kelurahan.required' => 'Desa/Kelurahan tidak boleh kosong',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $data = [
            'nama_lokasi_survey' => $request->nama_lokasi_survey,
            'desa_kelurahan_id' => $request->desa_kelurahan,
        ];

        LokasiSurvey::create($data);

        return response()->json(['success' => 'Success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LokasiSurvey  $lokasiSurvey
     * @return \Illuminate\Http\Response
     */
    public function show(LokasiSurvey $lokasiSurvey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LokasiSurvey  $lokasiSurvey
     * @return \Illuminate\Http\Response
     */
    public function edit(LokasiSurvey $lokasiSurvey)
    {
        return view('pages.masterData.lokasiSurvey.edit', compact('lokasiSurvey'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLokasiSurveyRequest  $request
     * @param  \App\Models\LokasiSurvey  $lokasiSurvey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LokasiSurvey $lokasiSurvey)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama_lokasi_survey' => ['required', Rule::unique('lokasi_survey')->ignore($lokasiSurvey->id)->withoutTrashed()],
                'provinsi' => 'required',
                'kabupaten_kota' => 'required',
                'kecamatan' => 'required',
                'desa_kelurahan' => 'required',

            ],
            [
                'nama_lokasi_survey.required' => 'Nama Lokasi Survey / Posko tidak boleh kosong',
                'nama_lokasi_survey.unique' => 'Kartu Lokasi Survey / Posko sudah terdaftar',
                'provinsi.required' => 'Provinsi tidak boleh kosong',
                'kabupaten_kota.required' => 'Kabupaten/Kota tidak boleh kosong',
                'kecamatan.required' => 'Kecamatan tidak boleh kosong',
                'desa_kelurahan.required' => 'Desa/Kelurahan tidak boleh kosong',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $data = [
            'nama_lokasi_survey' => $request->nama_lokasi_survey,
            'desa_kelurahan_id' => $request->desa_kelurahan,
        ];

        $lokasiSurvey->update($data);

        return response()->json(['success' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LokasiSurvey  $lokasiSurvey
     * @return \Illuminate\Http\Response
     */
    public function destroy(LokasiSurvey $lokasiSurvey)
    {
        $lokasiSurvey->delete();
        return response()->json(['success' => 'Success']);
    }
}
