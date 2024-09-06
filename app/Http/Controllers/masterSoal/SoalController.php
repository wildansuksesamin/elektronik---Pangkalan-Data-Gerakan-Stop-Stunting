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

class SoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $jawabanSurvey = JawabanSurvey::where('kategori_soal_id', $request->kategoriSoal)->first();
        $kategoriSoal = KategoriSoal::find($request->kategoriSoal);
        $survey = Survey::where('nama_survey_id', $kategoriSoal->nama_survey_id)->first();
        if ($request->ajax()) {
            $data = Soal::orderBy('urutan', 'asc')->where('kategori_soal_id', $request->kategoriSoal)->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) use ($request, $survey) {
                    $actionBtn = '
                            <button id="btn-preview" class="btn btn-primary btn-sm mr-1 my-1" title="Preview" onclick="preview(' . $row->id . ')"><i class="fas fa-edit"></i> Preview</button>
                            ';

                    if (!$survey) {
                        $actionBtn .= '<a id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1" title="Ubah" href="' . url('/soal' . '/' . $request->kategoriSoal) . '/' . $row->id . '/edit' . '"><i class="fas fa-edit"></i> Ubah</a>
                            <button id="btn-delete" onclick="hapus(' . $row->id . ')" class="btn btn-danger btn-sm mr-1 my-1" value="' . $row->id . '" title="Hapus"><i class="fas fa-trash"></i> Hapus</button>';
                    }

                    return $actionBtn;
                })
                ->addColumn('tipe_jawaban', function ($row) {
                    if ($row->tipe_jawaban == 'Pilihan Ganda') {
                        return '<span class="badge badge-primary">Pilihan Ganda</span>';
                    } else if ($row->tipe_jawaban == 'Kotak Centang') {
                        return '<span class="badge badge-success">Kotak Centang</span>';
                    } else {
                        return '<span class="badge badge-warning">Jawaban Singkat</span>';
                    }
                })
                ->rawColumns(['action', 'tipe_jawaban'])
                ->make(true);
        }
        $kategoriSoal = $request->kategoriSoal;
        $idNamaSurvey = KategoriSoal::where('id', $kategoriSoal)->first()->nama_survey_id;
        return view('pages.masterSoal.soal.index', compact('kategoriSoal', 'jawabanSurvey', 'idNamaSurvey'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $kategoriSoal = $request->kategoriSoal;
        return view('pages.masterSoal.soal.create', compact('kategoriSoal'));
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
                'urutan' => ['required', Rule::unique('soal')->where(function ($query) use ($request) {
                    $query->where([
                        ['kategori_soal_id', $request->kategoriSoal],
                        ['urutan', $request->urutan]
                    ]);
                })->withoutTrashed()],
                'soal' => 'required',
                'jawaban' => $request->tipe_jawaban != 'Jawaban Singkat' ? 'required' : 'nullable',
                'jawaban.*' => $request->tipe_jawaban != 'Jawaban Singkat' ? 'required' : 'nullable',
                'tipe_jawaban' => 'required',
            ],
            [
                'urutan.required' => "Urutan Tidak Boleh Dikosongkan",
                'urutan.unique' => "Urutan Sudah Ada",
                'soal.required' => "Soal Tidak Boleh Dikosongkan",
                'jawaban.required' => "Jawaban Opsi Tidak Boleh Dikosongkan",
                'jawaban.*.required' => "Jawaban Opsi Tidak Boleh Dikosongkan",
                'tipe_jawaban.required' => "Tipe Jawaban Tidak Boleh Dikosongkan",
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $soal = new Soal();
        $soal->kategori_soal_id = $request->kategoriSoal;
        $soal->urutan = $request->urutan;
        $soal->soal = $request->soal;
        $soal->is_numerik = $request->is_numerik ? $request->is_numerik : 0;
        $soal->tipe_jawaban = $request->tipe_jawaban;
        $soal->save();

        if ($request->tipe_jawaban != 'Jawaban Singkat') {
            for ($i = 0; $i < count($request->jawaban); $i++) {
                $jawabanSoal = new JawabanSoal();
                $jawabanSoal->jawaban = $request->jawaban[$i];
                $jawabanSoal->soal_id = $soal->id;
                $jawabanSoal->save();
            }

            if ($request->lainnya != '') {
                $jawabanSoal = new JawabanSoal();
                $jawabanSoal->jawaban = $request->lainnya;
                $jawabanSoal->soal_id = $soal->id;
                $jawabanSoal->is_lainnya = 1;
                $jawabanSoal->save();
            }
        }

        return response()->json([
            'status' => 'success',
            'url' => url('/soal' . '/' . $request->kategoriSoal)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $soal = Soal::with(['jawabanSoal' => function ($query) {
            $query->orderBy('is_lainnya', 'asc');
        }])->where('id', $request->soal)->first();

        $html = '';
        if ($soal->tipe_jawaban != 'Jawaban Singkat') {
            $html .= "<p>" . $soal->urutan . ". " . $soal->soal . "</p>";
            $tipe = '';
            if ($soal->tipe_jawaban == 'Pilihan Ganda') {
                $tipe = 'radio';
            } else {
                $tipe = 'checkbox';
            }
            foreach ($soal->jawabanSoal as $jawaban) {
                if ($jawaban->jawaban != 'Lainnya') {
                    $html .= "<div class='input-group my-2'>
                            <div class='input-group-text'><input class='form-check-input mt-0' type='" . $tipe . "' name='jawaban' value=''
                                    aria-label='Radio button for following text input' />
                            </div>
                            <input type='text' class='form-control text-jawaban'
                                aria-label='Text input with radio button' placeholder='" . $jawaban->jawaban . "' disabled value='" . $jawaban->jawaban . "'/>
                        </div>";
                } else {
                    $html .= "
                        <div class='input-group'>
                            <div class='input-group-text'><input class='form-check-input mt-0' type='" . $tipe . "' name='jawaban' value=''
                                    aria-label='Radio button for following text input' />
                            </div>
                            <input type='text' class='form-control text-jawaban'
                                aria-label='Text input with radio button' placeholder='Lainnya' />
                        </div>";
                }
            }
        } else {
            $is_numerik = $soal->is_numerik == 1 ? 'numerik' : '';
            $html .= "<p>" . $soal->urutan . ". " . $soal->soal . "</p>";

            $html .= "<input type='text' id='jawaban' class='form-control text-jawaban text-kotak-centang " . $is_numerik . "' placeholder='Masukkan Jawaban Anda' />";
        }
        return response()->json(
            [
                'status' => 'success',
                'html' => $html,
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $kategoriSoal = $request->kategoriSoal;
        $isiSoal = Soal::with(['jawabanSoal' => function ($query) {
            $query->orderBy('is_lainnya', 'asc');
        }])->where('id', $request->soal)->first();
        $idSoal = $request->soal;
        return view('pages.masterSoal.soal.edit', compact('kategoriSoal', 'isiSoal', 'idSoal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $soal = Soal::where('id', $request->soal)->first();
        $validator = Validator::make(
            $request->all(),
            [
                'urutan' => ['required', Rule::unique('soal')->where(function ($query) use ($request) {
                    $query->where([
                        ['kategori_soal_id', $request->kategoriSoal],
                        ['urutan', $request->urutan]
                    ]);
                })->ignore($request->soal)->withoutTrashed()],
                'soal_ubah' => 'required',
                'jawaban' => $soal->tipe_jawaban != 'Jawaban Singkat' && $request->jawaban ? 'required' : 'nullable',
                'jawaban.*' => $soal->tipe_jawaban != 'Jawaban Singkat' && $request->jawaban ? 'required' : 'nullable',
                'jawaban_ubah' => $soal->tipe_jawaban != 'Jawaban Singkat' && $request->jawaban_ubah ? 'required' : 'nullable',
                'jawaban_ubah.*' => $soal->tipe_jawaban != 'Jawaban Singkat' && $request->jawaban_ubah ? 'required' : 'nullable',
            ],
            [
                'urutan.required' => "Urutan Tidak Boleh Dikosongkan",
                'urutan.unique' => "Urutan Sudah Ada",
                'soal_ubah.required' => "Soal Tidak Boleh Dikosongkan",
                'jawaban.required' => "Jawaban Opsi Tidak Boleh Dikosongkan",
                'jawaban.*.required' => "Jawaban Opsi Tidak Boleh Dikosongkan",
                'jawaban_ubah.required' => "Jawaban Opsi Tidak Boleh Dikosongkan",
                'jawaban_ubah.*.required' => "Jawaban Opsi Tidak Boleh Dikosongkan",
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $soal->soal = $request->soal_ubah;
        $soal->urutan = $request->urutan;
        $soal->is_numerik = $request->is_numerik ? 1 : 0;
        $soal->save();

        // Hapus Jawaban Yang Dihapus Ketika Update
        if ($request->id_hapus) {
            $idHapus = explode(',', $request->id_hapus);
            for ($i = 0; $i < count($idHapus) - 1; $i++) {
                $jawaban = JawabanSoal::where('id', $idHapus[$i])->first();
                $jawaban->delete();
            }
        }

        if ($request->id_hapus_lainnya) {
            $idHapus = explode(',', $request->id_hapus_lainnya);
            for ($i = 0; $i < count($idHapus); $i++) {
                $jawaban = JawabanSoal::where('id', $idHapus[$i])->first();
                $jawaban->delete();
            }
        }

        // Update Jawaban Yang Telah Ada
        if ($request->jawaban_ubah) {
            for ($i = 0; $i < count($request->jawaban_ubah); $i++) {
                $jawaban = JawabanSoal::where('id', $request->id_jawaban_ubah[$i])->first();
                $jawaban->jawaban = $request->jawaban_ubah[$i];
                $jawaban->save();
            }
        }

        // Tambahkan Jawaban yang baru ditambahkan ketika update
        if ($request->jawaban) {
            for ($i = 0; $i < count($request->jawaban); $i++) {
                $jawaban = new JawabanSoal();
                $jawaban->soal_id = $request->soal;
                $jawaban->jawaban = $request->jawaban[$i];
                $jawaban->save();
            }
        }

        if ($request->lainnya != '') {
            $jawabanSoal = new JawabanSoal();
            $jawabanSoal->jawaban = $request->lainnya;
            $jawabanSoal->soal_id = $soal->id;
            $jawabanSoal->is_lainnya = 1;
            $jawabanSoal->save();
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Soal  $soal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $soal = Soal::with(['jawabanSoal'])->where('id', $request->soal)->first();
        $soal->jawabanSoal()->delete();
        $soal->delete();
        return response()->json(['status' => 'success']);
    }
}
