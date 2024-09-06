<?php

namespace App\Http\Controllers\masterSoal;

use App\Http\Controllers\Controller;
use App\Models\JawabanSoal;
use App\Models\KategoriSoal;
use App\Models\NamaSurvey;
use App\Models\Soal;
use App\Models\Survey;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class NamaSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = NamaSurvey::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tipe', function ($row) {
                    if ($row->tipe == "Pre") {
                        return '<span class="badge badge-primary">Pre</span>';
                    } else {
                        return '<span class="badge badge-success">Post</span>';
                    }
                })
                ->addColumn('aktif', function ($row) {
                    if ($row->is_aktif == 0) {
                        return '<span class="badge badge-danger">Tidak Aktif</span>';
                    } else {
                        return '<span class="badge badge-success">Aktif</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                            <a id="btn-edit" href="' . url('/kategoriSoal') . "/" . $row->id . '" class="btn btn-primary btn-sm mr-1 my-1" ><i class="fas fa-eye"></i> Lihat Kategori Soal</a>
                            ';

                    $actionBtn .= '<button id="btn-duplikat" class="btn btn-success btn-sm mr-1 my-1"  onclick="duplikat(' . $row->id . ')"><i class="fas fa-copy"></i> Duplikat</button>';

                    $actionBtn .= '<button id="btn-edit-status" class="btn btn-warning btn-sm mr-1 my-1"  onclick="editStatus(' . $row->id . ')"><i class="fas fa-edit"></i> Ubah Status</button>';

                    $survey = Survey::where('nama_survey_id', $row->id)->first();
                    if (!$survey) {
                        $actionBtn .= '<button id="btn-edit" class="btn btn-warning btn-sm mr-1 my-1"  onclick="edit(' . $row->id . ')"><i class="fas fa-edit"></i> Ubah</button>
                            <button id="btn-delete" onclick="hapus(' . $row->id . ')" class="btn btn-danger btn-sm mr-1 my-1" value="' . $row->id . '" title="Hapus"><i class="fas fa-trash"></i> Hapus</button>';
                    }

                    return $actionBtn;
                })
                ->rawColumns(['action', 'tipe', 'aktif'])
                ->make(true);
        }
        return view('pages.masterSoal.namaSurvey');
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
                'nama' => 'required',
                'tipe' => 'required',
                'status' => 'required'
            ],
            [
                'nama.required' => "Nama Survey Tidak Boleh Dikosongkan",
                'tipe.required' => "Tipe Survey Tidak Boleh Dikosongkan",
                'status.required' => "Status Survey Tidak Boleh Dikosongkan"
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $nama_survey = new NamaSurvey();
        $nama_survey->nama = $request->nama;
        $nama_survey->tipe = $request->tipe;
        $nama_survey->is_aktif = $request->status;
        $nama_survey->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NamaSurvey  $namaSurvey
     * @return \Illuminate\Http\Response
     */
    public function show(NamaSurvey $namaSurvey)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NamaSurvey  $namaSurvey
     * @return \Illuminate\Http\Response
     */
    public function edit(NamaSurvey $namaSurvey)
    {
        return response()->json(
            [
                'data' => $namaSurvey
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NamaSurvey  $namaSurvey
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NamaSurvey $namaSurvey)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required',
                'tipe' => 'required'
            ],
            [
                'nama.required' => "Nama Survey Tidak Boleh Dikosongkan",
                'tipe.required' => "Tipe Survey Tidak Boleh Dikosongkan",
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $namaSurvey->nama = $request->nama;
        $namaSurvey->tipe = $request->tipe;
        $namaSurvey->save();

        return response()->json(['status' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NamaSurvey  $namaSurvey
     * @return \Illuminate\Http\Response
     */
    public function destroy(NamaSurvey $namaSurvey)
    {
        $namaSurvey->delete();
        $kategoriSoal = KategoriSoal::where('nama_survey_id', $namaSurvey->id)->first();

        $namaSurvey->kategoriSoal()->delete();
        if ($kategoriSoal) {
            $daftarSoal = Soal::where('kategori_soal_id', $kategoriSoal->id)->get();
            if ($daftarSoal) {
                foreach ($daftarSoal as $soal) {
                    $soal->delete();
                    $soal->jawabanSoal()->delete();
                }
            }
        }
        return response()->json(['status' => 'success']);
    }

    public function duplikat(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nama' => 'required',
                'tipe' => 'required'
            ],
            [
                'nama.required' => "Nama Survey Tidak Boleh Dikosongkan",
                'tipe.required' => "Tipe Survey Tidak Boleh Dikosongkan",
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $namaSurveyLama = NamaSurvey::find($id);

        // Insert Nama Survey Baru
        $nama_survey = new NamaSurvey();
        $nama_survey->nama = $request->nama;
        $nama_survey->tipe = $request->tipe;
        $nama_survey->save();

        // Insert Kategori Berdasarkan Survey Yang Diduplikasi
        if ($namaSurveyLama->kategoriSoal) {
            foreach ($namaSurveyLama->kategoriSoal as $kategori) {
                $kategoriSoal = new KategoriSoal();
                $kategoriSoal->urutan = $kategori->urutan;
                $kategoriSoal->nama = $kategori->nama;
                $kategoriSoal->nama_survey_id = $nama_survey->id;
                $kategoriSoal->save();

                // Insert Soal Berdasarkan Kategori
                if ($kategori->soal) {
                    foreach ($kategori->soal as $soal) {
                        $soalDuplikat = new Soal();
                        $soalDuplikat->kategori_soal_id = $kategoriSoal->id;
                        $soalDuplikat->urutan = $soal->urutan;
                        $soalDuplikat->soal = $soal->soal;
                        $soalDuplikat->is_numerik = $soal->is_numerik ? $soal->is_numerik : 0;
                        $soalDuplikat->tipe_jawaban = $soal->tipe_jawaban;
                        $soalDuplikat->save();

                        // Insert Jawaban Soal Berdasarkan Soal
                        if (count($soal->jawabanSoal) > 0) {
                            foreach ($soal->jawabanSoal as $jawaban) {
                                $jawabanDuplikat = new JawabanSoal();
                                $jawabanDuplikat->jawaban = $jawaban->jawaban;
                                $jawabanDuplikat->soal_id = $soalDuplikat->id;
                                $jawabanDuplikat->is_lainnya = $jawaban->is_lainnya;
                                $jawabanDuplikat->save();
                            }
                        }
                    }
                }
            }
        }


        return response()->json(['status' => 'success']);
    }

    public function statusAktif(NamaSurvey $namaSurvey, Request $request)
    {
        $statusAktif = $request->status_edit;

        $namaSurvey->is_aktif = $statusAktif;
        $namaSurvey->save();

        return response()->json(['status' => 'success']);
    }
}
