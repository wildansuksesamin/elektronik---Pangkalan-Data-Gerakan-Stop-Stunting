<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Survey;
use App\Models\Profile;
use App\Models\Institusi;
use App\Models\Responden;
use App\Models\KategoriSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\LokasiSurveySupervisor;
use App\Models\NamaSurvey;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        if ($profile == null) {
            return redirect(route('lengkapiProfile'));
        } else {
            if (in_array(Auth::user()->role, array('Admin', 'Sub Admin', 'Supervisor', 'Institusi'))) {
                $dataAdmin = [
                    'survey' => Survey::where('is_selesai', 1)->get(),
                    'nama_survey' => NamaSurvey::all(),
                    'totalSurvey' => Survey::where('is_selesai', 1)->count(),
                    'totalSurveyPre' => Survey::with('namaSurvey')->whereHas('namaSurvey', function ($query) {
                        $query->where('tipe', 'Pre');
                    })->where('is_selesai', 1)->count(),
                    'totalSurveyPost' => Survey::with('namaSurvey')->whereHas('namaSurvey', function ($query) {
                        $query->where('tipe', 'Post');
                    })->where('is_selesai', 1)->count(),
                    'totalSurveyor' => Profile::with('user')->whereHas('user', function ($query) {
                        $query->where('role', 'Surveyor');
                    })->count(),
                    'totalResponden' => Responden::count(),
                    'riwayatSurveyHariIni' => Survey::where('is_selesai', 1)->whereDate('updated_at', '=', date('Y-m-d'))->orderBy('updated_at', 'DESC'),
                    'riwayatSurveyMingguIni' => Survey::with('responden', 'namaSurvey', 'profile')
                        ->where('is_selesai', 1)
                        ->where(function ($query) {
                            $query->whereBetween('updated_at', [date('Y-m-d', strtotime('-7 days')), date('Y-m-d')])
                                ->orWhereDate('updated_at', '=', date('Y-m-d'))->latest();
                        })->orderBy('updated_at', 'DESC'),
                    'riwayatSurveyBulanIni' => Survey::with('responden', 'namaSurvey', 'profile')
                        ->where('is_selesai', 1)
                        ->where(function ($query) {
                            $query->whereBetween('updated_at', [date('Y-m-d', strtotime('-30 days')), date('Y-m-d')])
                                ->orWhereDate('updated_at', '=', date('Y-m-d'));
                        })->orderBy('updated_at', 'DESC'),

                    'daftarTahun' => Survey::select(DB::raw('YEAR(updated_at) as tahun'))->groupBy('tahun')->latest()->get(),
                    // Jumlah perbulan di tahun ini
                ];

                $dataInstitusi = [
                    'survey' => Survey::with('profile')->where('is_selesai', 1)->whereHas('profile', function ($query) {
                        $query->where('institusi_id', Auth::user()->profile->institusi_id);
                    })->get(),
                    'nama_survey' => NamaSurvey::all(),
                    'totalSurvey' => Survey::with('profile')->where('is_selesai', 1)->whereHas('profile', function ($query) {
                        $query->where('institusi_id', Auth::user()->profile->institusi_id);
                    })->count(),
                    'totalSurveyor' => Profile::with('user')
                        ->whereHas('user', function ($query) {
                            $query->where('role', 'Surveyor');
                        })->where('institusi_id', Auth::user()->profile->institusi_id)->count(),
                    'totalSupervisor' => Profile::with('user')
                        ->whereHas('user', function ($query) {
                            $query->where('role', 'Supervisor');
                        })->where('institusi_id', Auth::user()->profile->institusi_id)->count(),
                    'totalLokasiSurvey' => LokasiSurveySupervisor::whereHas('profile', function ($query) {
                        $query->where('institusi_id', Auth::user()->profile->institusi_id);
                    })->count(),
                    'riwayatSurveyHariIni' => Survey::with('responden', 'namaSurvey', 'profile')
                        ->where('is_selesai', 1)->whereHas('profile', function ($query) {
                            $query->where('institusi_id', Auth::user()->profile->institusi_id);
                        })->whereDate('updated_at', '=', date('Y-m-d'))->orderBy('updated_at', 'DESC'),
                    'riwayatSurveyMingguIni' => Survey::with('responden', 'namaSurvey', 'profile')
                        ->where('is_selesai', 1)->whereHas('profile', function ($query) {
                            $query->where('institusi_id', Auth::user()->profile->institusi_id);
                        })->where(function ($query) {
                            $query->whereBetween('updated_at', [date('Y-m-d', strtotime('-7 days')), date('Y-m-d')])
                                ->orWhereDate('updated_at', '=', date('Y-m-d'))->latest();
                        })->orderBy('updated_at', 'DESC'),
                    'riwayatSurveyBulanIni' => Survey::with('responden', 'namaSurvey', 'profile')
                        ->where('is_selesai', 1)->whereHas('profile', function ($query) {
                            $query->where('institusi_id', Auth::user()->profile->institusi_id);
                        })->where(function ($query) {
                            $query->whereBetween('updated_at', [date('Y-m-d', strtotime('-30 days')), date('Y-m-d')])
                                ->orWhereDate('updated_at', '=', date('Y-m-d'));
                        })->orderBy('updated_at', 'DESC'),
                ];

                $dataSupervisor = [
                    'survey' => Survey::with('profile')->where('is_selesai', 1)
                        ->whereHas('profile', function ($query) {
                            $query->whereHas('anggotaSupervisor', function ($query) {
                                $query->where('profile_dpl', Auth::user()->profile->id);
                            });
                        })->get(),
                    'nama_survey' => NamaSurvey::all(),
                    'totalSurvey' => Survey::with('profile')->where('is_selesai', 1)
                        ->whereHas('profile', function ($query) {
                            $query->whereHas('anggotaSupervisor', function ($query) {
                                $query->where('profile_dpl', Auth::user()->profile->id);
                            });
                        })->count(),
                    'totalSurveyor' => Profile::with('anggotaSupervisor')
                        ->whereHas('anggotaSupervisor', function ($query) {
                            $query->where('profile_dpl', Auth::user()->profile->id);
                        })->count(),
                    'totalLokasiSurvey' => LokasiSurveySupervisor::where('profile_id', Auth::user()->profile->id)->count(),
                    'riwayatSurveyHariIni' => Survey::with('responden', 'namaSurvey', 'profile')
                        ->where('is_selesai', 1)->whereHas('profile', function ($query) {
                            $query->whereHas('anggotaSupervisor', function ($query) {
                                $query->where('profile_dpl', Auth::user()->profile->id);
                            });
                        })->whereDate('updated_at', '=', date('Y-m-d'))->orderBy('updated_at', 'DESC'),
                    'riwayatSurveyMingguIni' => Survey::with('responden', 'namaSurvey', 'profile')
                        ->where('is_selesai', 1)->whereHas('profile', function ($query) {
                            $query->whereHas('anggotaSupervisor', function ($query) {
                                $query->where('profile_dpl', Auth::user()->profile->id);
                            });
                        })->where(function ($query) {
                            $query->whereBetween('updated_at', [date('Y-m-d', strtotime('-7 days')), date('Y-m-d')])
                                ->orWhereDate('updated_at', '=', date('Y-m-d'))->latest();
                        })->orderBy('updated_at', 'DESC'),
                    'riwayatSurveyBulanIni' => Survey::with('responden', 'namaSurvey', 'profile')
                        ->where('is_selesai', 1)->whereHas('profile', function ($query) {
                            $query->whereHas('anggotaSupervisor', function ($query) {
                                $query->where('profile_dpl', Auth::user()->profile->id);
                            });
                        })->where(function ($query) {
                            $query->whereBetween('updated_at', [date('Y-m-d', strtotime('-30 days')), date('Y-m-d')])
                                ->orWhereDate('updated_at', '=', date('Y-m-d'));
                        })->orderBy('updated_at', 'DESC'),
                ];
                if (in_array(Auth::user()->role, ['Admin', 'Sub Admin'])) {
                    return view('pages.dashboard.admin', $dataAdmin);
                } else if (Auth::user()->role == 'Institusi') {
                    return view('pages.dashboard.institusi', $dataInstitusi);
                } else if (Auth::user()->role == 'Supervisor') {
                    return view('pages.dashboard.supervisor', $dataSupervisor);
                }
            } else if (Auth::user()->role == 'Surveyor') {
                // Jumlahnya masih mau diubah sesuai surveyor yang login
                $profile = Profile::where('user_id', Auth::user()->id)->first();
                $data = [
                    'totalRespondenAnda' => Survey::where('profile_id', $profile->id)->count(),
                    'totalRespondenPre' => Survey::with('responden', 'namaSurvey', 'profile')->where('profile_id', $profile->id)->whereHas('namaSurvey', function ($query) {
                        $query->where('tipe', 'Pre');
                    })->count(),
                    'totalRespondenPost' => Survey::with('responden', 'namaSurvey', 'profile')->where('profile_id', $profile->id)->whereHas('namaSurvey', function ($query) {
                        $query->where('tipe', 'Post');
                    })->count(),
                ];
                return view('pages.dashboard.surveyor', $data);
            }
        }
    }

    public function surveyBelumSelesai(Request $request)
    {
        $profile = Profile::where('user_id', Auth::user()->id)->first();
        if ($request->ajax()) {
            $data = Survey::with(['responden', 'namaSurvey', 'profile'])->where('profile_id', $profile->id)->where('is_selesai', 0)->orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    return '<h6 class="text-uppercase fw-bold mb-0">Responden: ' . $row->responden->kartu_keluarga . '</h6>
                                    <span class="text-muted mb-4">Judul:  ' . $row->namaSurvey->nama . '</span>';
                })
                ->addColumn('tipe', function ($row) {
                    if ($row->namaSurvey->tipe == "Pre") {
                        return '<span class="text-warning">PRE</span>';
                    } else {
                        return '<span class="text-danger">POST</span>';
                    }
                })
                ->addColumn('tanggal', function ($row) {
                    return Carbon::parse($row->created_at)->translatedFormat('d F Y');
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                        <a href="' . url('/survey/pertanyaan-survey') . "/" . $row->kode_unik . "/" . $row->kategori_selanjutnya . '" class="btn btn-warning btn-sm mr-1 my-1" title="Ubah"><i class="far fa-play-circle"></i> Lanjutkan</a>
                    </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'nama', 'tipe'])
                ->make(true);
        }
        // return view('pages.survey.index');
    }

    public function statistikSurvey(Request $request)
    {
        $jumlahPerbulan = Survey::select(DB::raw('MONTHNAME(created_at) as bulan, MONTH(created_at) as bulanAngka, COUNT(*) as jumlah'))
            ->whereYear('created_at', $request->tahun)
            ->groupBy('bulanAngka')
            ->orderBy('bulanAngka', 'asc')
            ->where('is_selesai', 1)
            ->get();

        $jumlahPerbulanPre = Survey::with('namaSurvey')->select(DB::raw('MONTH(created_at) as bulan, COUNT(*) as jumlah'))->whereYear('created_at', $request->tahun)->groupBy('bulan')->whereHas('namaSurvey', function ($query) {
            $query->where('tipe', 'Pre');
        })->where('is_selesai', 1)->orderBy('bulan', 'asc')->get();

        $jumlahPerbulanPost = Survey::with('namaSurvey')->select(DB::raw('MONTH(created_at) as bulan, COUNT(*) as jumlah'))->whereYear('created_at', $request->tahun)->groupBy('bulan')->whereHas('namaSurvey', function ($query) {
            $query->where('tipe', 'Post');
        })->where('is_selesai', 1)->orderBy('bulan', 'asc')->get();

        $jsonJumlahPerbulan = [];
        foreach ($jumlahPerbulan as $bulan) {
            $jsonJumlahPerbulan[] = $bulan->jumlah;
        }

        $jsonJumlahPerbulanPre = [];
        foreach ($jumlahPerbulanPre as $bulan) {
            $jsonJumlahPerbulanPre[] = $bulan->jumlah;
        }

        $jsonJumlahPerbulanPost = [];
        foreach ($jumlahPerbulanPost as $bulan) {
            $jsonJumlahPerbulanPost[] = $bulan->jumlah;
        }

        $jsonNamaBulan = [];
        foreach ($jumlahPerbulan as $bulan) {
            $jsonNamaBulan[] = substr($bulan->bulan, 0, 3);
        }

        $data = [
            'tahun' => $request->tahun,
            'jsonJumlahPerbulan' => $jsonJumlahPerbulan,
            // 'jumlahPerbulanPre' => $jumlahPerbulanPre,
            // 'jumlahPerbulanPost' => $jumlahPerbulanPost,
            'jsonJumlahPerbulanPre' => $jsonJumlahPerbulanPre,
            'jsonJumlahPerbulanPost' => $jsonJumlahPerbulanPost,
            'jsonNamaBulan' => $jsonNamaBulan,
        ];

        return response()->json($data);
    }



    public function editProfileAccount()
    {
        $data = [
            'user' => User::find(Auth::user()->id),
            'institusi' => Institusi::latest()->get(),
            'profile' => Profile::select('*', DB::raw('DATE_FORMAT(tanggal_lahir, "%d/%m/%Y") AS tanggal_lahir'))->where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'DESC')->first(),

        ];
        return view('pages.editProfileUser', $data);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'institusi_id' => 'required',
                'nama_lengkap' => 'required',
                'jenis_kelamin' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'alamat' => 'required',
                'provinsi' => 'required',
                'kabupaten_kota' => 'required',
                'kecamatan' => 'required',
                'desa_kelurahan' => 'required',
                'nomor_hp' => 'required',
            ],
            [
                'institusi_id' => 'required',
                'nama_lengkap.required' => 'Nama Lengkap tidak boleh kosong',
                'jenis_kelamin.required' => 'Jenis Kelamin tidak boleh kosong',
                'tempat_lahir.required' => 'Tempat Lahir tidak boleh kosong',
                'tanggal_lahir.required' => 'Tanggal Lahir tidak boleh kosong',
                'alamat.required' => 'Alamat tidak boleh kosong',
                'provinsi.required' => 'Provinsi tidak boleh kosong',
                'kabupaten_kota.required' => 'Kabupaten/Kota tidak boleh kosong',
                'kecamatan.required' => 'Kecamatan tidak boleh kosong',
                'desa_kelurahan.required' => 'Desa/Kelurahan tidak boleh kosong',
                'nomor_hp.required' => 'Nomor HP tidak boleh'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $data = [
            'user_id' => Auth::user()->id,
            'institusi_id' => $request->institusi_id,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => date("Y-m-d", strtotime($request->tanggal_lahir)),
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kabupaten_kota' => $request->kabupaten_kota,
            'kecamatan' => $request->kecamatan,
            'desa_kelurahan' => $request->desa_kelurahan,
            'nomor_hp' => $request->nomor_hp,
            'email' => $request->email,
        ];

        $profile = Profile::where('user_id', '=', Auth::user()->id)->first();

        if ($profile) {
            $profile->update($data);
        } else {
            Profile::create($data);
        }

        // Profile::where('id', $profile->id)->update($data);

        return response()->json(['success' => 'Success']);
    }

    public function updateAccount(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $validator = Validator::make(
            $request->all(),
            [
                'username' => ['required', Rule::unique('users')->ignore($user->id)->withoutTrashed()],
                // 'password' => 'required',
            ],
            [
                'username.required' => 'Nama Pengguna tidak boleh kosong',
                'username.unique' => 'Nama Pengguna sudah terdaftar',
                // 'password.required' => 'Kata Sandi tidak boleh kosong',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        if ($request->password == '') {
            $password = $user->password;
        } else {
            $password = bcrypt($request->password);
        }

        $data = [
            'username' => $request->username,
            'password' => $password
        ];

        User::where('id', $user->id)->update($data);

        return response()->json(['success' => 'Success']);
    }
}
