<?php

namespace App\Http\Controllers\masterData;

use App\Exports\RespondenExport;
use App\Models\Responden;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ListController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class RespondenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Responden::with('provinsi', 'kabupaten_kota', 'kecamatan', 'desa_kelurahan')->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('provinsi', function ($row) {
                    return $row->provinsi->nama;
                })
                ->addColumn('kabupaten_kota', function ($row) {
                    return $row->kabupaten_kota->nama;
                })
                ->addColumn('kecamatan', function ($row) {
                    return $row->kecamatan->nama;
                })
                ->addColumn('desa_kelurahan', function ($row) {
                    return $row->desa_kelurahan->nama;
                })
                ->addColumn('action', function ($row) {
                    if (Auth::user()->role == "Admin") {
                        $actionBtn = '
                <div class="row text-center justify-content-center">';
                        $actionBtn .= '
                    <a href="' . route('responden.show', $row->id) . '" class="btn btn-info btn-sm mr-1 my-1" data-toggle="tooltip" data-placement="top" title="Lihat"><i class="fas fa-eye"></i></a>
                    <a href="' . route('responden.edit', $row->id) . '" id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1" data-toggle="tooltip" data-placement="top" title="Ubah"><i class="fas fa-edit"></i></a>
                    <button id="btn-delete" onclick="hapus(' . $row->id . ')" class="btn btn-danger btn-sm mr-1 my-1" value="' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>
                </div>';
                    } else {
                        $actionBtn = '
                <div class="row text-center justify-content-center">';
                        $actionBtn .= '
                    <a href="' . route('responden.show', $row->id) . '" class="btn btn-info btn-sm mr-1 my-1" data-toggle="tooltip" data-placement="top" title="Lihat"><i class="fas fa-eye"></i></a>
                </div>';
                    }

                    return $actionBtn;
                })
                ->filter(function ($query) use ($request) {
                    if ($request->search != '') {
                        $query->where(function ($query) use ($request) {
                            $query->where("nama_kepala_keluarga", "LIKE", "%$request->search%");

                            $query->orWhere("kartu_keluarga", "LIKE", "%$request->search%");
                        });
                    }

                    if (!empty($request->provinsi)) {
                        $query->whereHas('provinsi', function ($query) use ($request) {
                            $query->where('id', $request->provinsi);
                        });
                    }

                    if (!empty($request->kabupaten)) {
                        $query->whereHas('kabupaten_kota', function ($query) use ($request) {
                            $query->where('id', $request->kabupaten);
                        });
                    }

                    if (!empty($request->kecamatan)) {
                        $query->whereHas('kecamatan', function ($query) use ($request) {
                            $query->where('id', $request->kecamatan);
                        });
                    }

                    if (!empty($request->desa)) {
                        $query->whereHas('desa_kelurahan', function ($query) use ($request) {
                            $query->where('id', $request->desa);
                        });
                    }
                })
                ->rawColumns(['provinsi', 'kabupaten_kota', 'kecamatan', 'desa_kelurahan', 'action'])
                ->make(true);
        }
        return view('pages.masterData.responden.index');
    }

    // Khusus Surveyor
    public function pilihResponden()
    {
        $responden = Responden::latest()->get();
        return view('pages.survey.pilihResponden', compact('responden'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.masterData.responden.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRespondenRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kartu_keluarga' => ['required', Rule::unique('responden')->withoutTrashed()],
                'nama_kepala_keluarga' => 'required',
                'alamat' => 'required',
                'provinsi' => 'required',
                'kabupaten_kota' => 'required',
                'kecamatan' => 'required',
                'desa_kelurahan' => 'required',

            ],
            [
                'kartu_keluarga.required' => 'Kartu keluarga tidak boleh kosong',
                'kartu_keluarga.unique' => 'Kartu keluarga sudah terdaftar',
                'nama_kepala_keluarga.required' => 'Kepala keluarga tidak boleh kosong',
                'alamat.required' => 'Alamat tidak boleh kosong',
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
            'kartu_keluarga' => $request->kartu_keluarga,
            'nama_kepala_keluarga' => $request->nama_kepala_keluarga,
            'alamat' => $request->alamat,
            'provinsi_id' => $request->provinsi,
            'kabupaten_kota_id' => $request->kabupaten_kota,
            'kecamatan_id' => $request->kecamatan,
            'desa_kelurahan_id' => $request->desa_kelurahan,
            'nomor_hp' => $request->nomor_hp,
            'kode_unik' => $this->generateKodeUnik(),
        ];

        Responden::create($data);

        return response()->json(['success' => 'Success']);
    }

    public function insertResponden(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kartu_keluarga' => ['required', Rule::unique('responden')->withoutTrashed()],
                'nama_kepala_keluarga' => 'required',
                'alamat' => 'required',
                'provinsi' => 'required',
                'kabupaten_kota' => 'required',
                'kecamatan' => 'required',
                'desa_kelurahan' => 'required',

            ],
            [
                'kartu_keluarga.required' => 'Kartu keluarga tidak boleh kosong',
                'kartu_keluarga.unique' => 'Kartu keluarga sudah terdaftar',
                'nama_kepala_keluarga.required' => 'Kepala keluarga tidak boleh kosong',
                'alamat.required' => 'Alamat tidak boleh kosong',
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
            'kartu_keluarga' => $request->kartu_keluarga,
            'nama_kepala_keluarga' => $request->nama_kepala_keluarga,
            'alamat' => $request->alamat,
            'provinsi_id' => $request->provinsi,
            'kabupaten_kota_id' => $request->kabupaten_kota,
            'kecamatan_id' => $request->kecamatan,
            'desa_kelurahan_id' => $request->desa_kelurahan,
            'nomor_hp' => $request->nomor_hp,
            'kode_unik' => $this->generateKodeUnik(),
        ];

        Responden::create($data);

        return response()->json(['success' => 'Success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Responden  $responden
     * @return \Illuminate\Http\Response
     */
    public function show(Responden $responden)
    {
        return view('pages.masterData.responden.show', compact('responden'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Responden  $responden
     * @return \Illuminate\Http\Response
     */
    public function edit(Responden $responden)
    {
        return view('pages.masterData.responden.edit', compact('responden'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRespondenRequest  $request
     * @param  \App\Models\Responden  $responden
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Responden $responden)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'kartu_keluarga' => ['required', Rule::unique('responden')->ignore($responden->id)->withoutTrashed()],
                'nama_kepala_keluarga' => 'required',
                'alamat' => 'required',
                'provinsi' => 'required',
                'kabupaten_kota' => 'required',
                'kecamatan' => 'required',
                'desa_kelurahan' => 'required',

            ],
            [
                'kartu_keluarga.required' => 'Kartu keluarga tidak boleh kosong',
                'kartu_keluarga.unique' => 'Kartu keluarga sudah terdaftar',
                'nama_kepala_keluarga.required' => 'Kepala keluarga tidak boleh kosong',
                'alamat.required' => 'Alamat tidak boleh kosong',
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
            'kartu_keluarga' => $request->kartu_keluarga,
            'nama_kepala_keluarga' => $request->nama_kepala_keluarga,
            'alamat' => $request->alamat,
            'provinsi_id' => $request->provinsi,
            'kabupaten_kota_id' => $request->kabupaten_kota,
            'kecamatan_id' => $request->kecamatan,
            'desa_kelurahan_id' => $request->desa_kelurahan,
            'nomor_hp' => $request->nomor_hp,
        ];

        $responden->update($data);

        return response()->json(['success' => 'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Responden  $responden
     * @return \Illuminate\Http\Response
     */
    public function destroy(Responden $responden)
    {
        $responden->delete();

        return response()->json(['success' => 'Success']);
    }

    //
    public function generateKodeUnik()
    {
        do {
            $code = random_int(10000000, 99999999);
        } while (Responden::where("kode_unik", "=", $code)->first());

        return $code;
    }

    public function export(Request $request)
    {
        $provinsi = $request->provinsi;
        $kabupaten_kota = $request->kabupaten_kota;
        $kecamatan = $request->kecamatan;
        $desa_kelurahan = $request->desa_kelurahan;

        $responden = Responden::with('provinsi', 'kabupaten_kota', 'kecamatan', 'desa_kelurahan')->orderBy('created_at', 'DESC')->where(function ($query) use ($provinsi, $kabupaten_kota, $kecamatan, $desa_kelurahan) {
            if (!empty($provinsi)) {
                $query->whereHas('provinsi', function ($query) use ($provinsi) {
                    $query->where('id', $provinsi);
                });
            }

            if (!empty($kabupaten_kota)) {
                $query->whereHas('kabupaten_kota', function ($query) use ($kabupaten_kota) {
                    $query->where('id', $kabupaten_kota);
                });
            }

            if (!empty($kecamatan)) {
                $query->whereHas('kecamatan', function ($query) use ($kecamatan) {
                    $query->where('id', $kecamatan);
                });
            }

            if (!empty($desa_kelurahan)) {
                $query->whereHas('desa_kelurahan', function ($query) use ($desa_kelurahan) {
                    $query->where('id', $desa_kelurahan);
                });
            }
        })->get();

        $tanggal = Carbon::parse(Carbon::now())->translatedFormat('d F Y');

        return Excel::download(new RespondenExport($responden), 'Data Responden-' . $tanggal . '.xlsx');
    }
}
