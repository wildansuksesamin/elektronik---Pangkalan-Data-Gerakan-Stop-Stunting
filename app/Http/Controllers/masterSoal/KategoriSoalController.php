<?php

namespace App\Http\Controllers\masterSoal;

use App\Http\Controllers\Controller;
use App\Models\JawabanSoal;
use App\Models\JawabanSurvey;
use App\Models\KategoriSoal;
use App\Models\Soal;
use App\Models\Survey;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class KategoriSoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $survey = Survey::where('nama_survey_id', $request->namaSurvey)->first();
        if ($request->ajax()) {
            $data = KategoriSoal::orderBy('urutan', 'asc')->where('nama_survey_id', $request->namaSurvey)->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) use ($survey) {
                    $actionBtn = '
                            <a id="btn-edit" href="' . url('/soal') . "/" . $row->id . '" class="btn btn-primary btn-sm mr-1 my-1" title="Ubah"><i class="fas fa-eye"></i> Lihat Daftar Soal</a>
                            ';

                    if (!$survey) {
                        $actionBtn .= '<button id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1" title="Ubah" onclick="edit(' . $row->id . ')"><i class="fas fa-edit"></i> Ubah</button>
                            <button id="btn-delete" onclick="hapus(' . $row->id . ')" class="btn btn-danger btn-sm mr-1 my-1" value="' . $row->id . '" title="Hapus"><i class="fas fa-trash"></i> Hapus</button>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $namaSurvey = $request->namaSurvey;
        return view('pages.masterSoal.kategoriSoal', compact('namaSurvey', 'survey'));
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
        $validator = Validator::make(
            $request->all(),
            [
                'urutan' => ['required', Rule::unique('kategori_soal')->where(function ($query) use ($request) {
                    $query->where([
                        ['nama_survey_id', $request->namaSurvey],
                        ['urutan', $request->urutan]
                    ]);
                })->withoutTrashed()],
                'nama' => 'required'
            ],
            [
                'urutan.required' => "Urutan Tidak Boleh Dikosongkan",
                'urutan.unique' => "Urutan Sudah Ada",
                'nama.required' => "Nama Survey Tidak Boleh Dikosongkan",
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $kategoriSoal = new KategoriSoal();
        $kategoriSoal->urutan = $request->urutan;
        $kategoriSoal->nama = $request->nama;
        $kategoriSoal->nama_survey_id = $request->namaSurvey;
        $kategoriSoal->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KategoriSoal  $kategoriSoal
     * @return \Illuminate\Http\Response
     */
    public function show(KategoriSoal $kategoriSoal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KategoriSoal  $kategoriSoal
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $kategoriSoal = KategoriSoal::where('id', $request->kategoriSoal)->first();
        return response()->json([
            'status' => 'success',
            'data' => $kategoriSoal
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KategoriSoal  $kategoriSoal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'urutan' => ['required', Rule::unique('kategori_soal')->where(function ($query) use ($request) {
                    $query->where([
                        ['nama_survey_id', $request->namaSurvey],
                        ['urutan', $request->urutan]
                    ]);
                })->ignore($request->kategoriSoal)->withoutTrashed()],
                'nama' => 'required'
            ],
            [
                'urutan.required' => "Urutan Tidak Boleh Dikosongkan",
                'urutan.unique' => "Urutan Sudah Ada",
                'nama.required' => "Nama Survey Tidak Boleh Dikosongkan",
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $kategoriSoal = KategoriSoal::where('id', $request->kategoriSoal)->first();
        $kategoriSoal->urutan = $request->urutan;
        $kategoriSoal->nama = $request->nama;
        $kategoriSoal->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KategoriSoal  $kategoriSoal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $kategoriSoal = KategoriSoal::with(['soal'])->where('id', $request->kategoriSoal)->first();

        $daftarSoal = Soal::where('kategori_soal_id', $request->kategoriSoal)->get();
        foreach ($daftarSoal as $soal) {
            $soal->delete();
            $soal->jawabanSoal()->delete();
        }


        $kategoriSoal->soal()->delete();
        $kategoriSoal->delete();

        return response()->json(['status' => 'success']);
    }
}
