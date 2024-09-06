<?php

namespace App\Http\Controllers\survey;

use App\Exports\SurveyExport;
use App\Http\Controllers\Controller;
use App\Models\Institusi;
use App\Models\JawabanSurvey;
use Illuminate\Http\Request;
use App\Models\Survey;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\KategoriSoal;
use App\Models\NamaSurvey;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class ExportSurveyController extends Controller
{
    public function index(Request $request)
    {
        if (isset($_GET['cari'])) {
            $halaman = '';
        } else {
            $halaman = $_GET['page'] ?? '';
        }

        $namaSurvey = NamaSurvey::all();
        $surveyor = Profile::with(['user'])
            ->where(function ($query) {
                if (Auth::user()->role == "Supervisor") {
                    $query->whereHas('anggotaSupervisor', function ($query) {
                        $query->where('profile_dpl', Auth::user()->profile->id);
                    });
                };

                if (Auth::user()->role == "Institusi") {
                    $query->where('institusi_id', Auth::user()->profile->institusi_id);
                }
            })
            ->whereHas('user', function ($user) {
                $user->where('role', '=', 'surveyor');
            })->orderBy('nama_lengkap')->get();
        $institusi = Institusi::orderBy('nama', 'asc')->get();

        // Filter
        $surveyor_id = $request->surveyor_id;
        $nama_survey_id = $request->nama_survey_id;
        $institusi_id = $request->institusi_id;
        $supervisorId = $request->supervisor_id;

        $data = Survey::with(['responden', 'namaSurvey', 'profile'])->where('is_selesai', 1)
            ->where(function ($query) use ($surveyor_id) {
                if (Auth::user()->role == "Surveyor") {
                    $query->where('profile_id', Auth::user()->profile->id);
                } else {
                    if ($surveyor_id != 'semua' && $surveyor_id != null) {
                        $query->where('profile_id', $surveyor_id);
                    }
                }
            })
            ->where(function ($query) use ($supervisorId) {
                if (Auth::user()->role == "Supervisor") {
                    $query->whereHas('anggotaSupervisor', function ($query) {
                        $query->where('profile_dpl', Auth::user()->profile->id);
                    });
                }

                if (in_array(Auth::user()->role, ['Admin', 'Sub Admin'])) {
                    if ($supervisorId != 'semua' && $supervisorId != null) {
                        $query->whereHas('anggotaSupervisor', function ($query) use ($supervisorId) {
                            $query->where('profile_dpl', $supervisorId);
                        });
                    }
                }
            })
            ->where(function ($query) use ($institusi_id) {
                if (Auth::user()->role != "Surveyor" && $institusi_id != 'semua' && $institusi_id != null) {
                    $query->whereHas('profile', function ($query) use ($institusi_id) {
                        $query->where('institusi_id', $institusi_id);
                    });
                }
            })
            ->where('nama_survey_id', $nama_survey_id)->orderBy('updated_at', 'DESC')->paginate(50)->withQueryString();

        return view('pages.survey.exportSurvey.index', compact('namaSurvey', 'surveyor', 'institusi', 'data', 'halaman'));
    }

    public function exportSurvey(Request $request)
    {
        // dd($request->page);
        $surveyor_id = $request->filter_surveyor;
        $institusi_id = $request->filter_institusi;
        $supervisorId = Auth::user()->role == "Supervisor" ? Auth::user()->profile->id : $request->filter_supervisor;
        $this->validate(
            $request,
            [
                'surveyor_id' => 'nullable',
                'filter_nama_survey' => 'required'
            ],
            [
                'filter_nama_survey.required' => "Nama Survey Tidak Boleh Dikosongkan",
            ]
        );

        $survey = Survey::with(['responden', 'namaSurvey', 'profile'])->where('is_selesai', 1)
            ->where(function ($query) use ($surveyor_id) {
                if (Auth::user()->role == "Surveyor") {
                    $query->where('profile_id', Auth::user()->profile->id);
                } else {
                    if ($surveyor_id != 'semua' && $surveyor_id != null) {
                        $query->where('profile_id', $surveyor_id);
                    }
                }
            })
            ->where(function ($query) use ($supervisorId) {
                if (Auth::user()->role == "Supervisor") {
                    $query->whereHas('anggotaSupervisor', function ($query) {
                        $query->where('profile_dpl', Auth::user()->profile->id);
                    });
                }

                if (in_array(Auth::user()->role, ['Admin', 'Sub Admin'])) {
                    if ($supervisorId != 'semua' && $supervisorId != null) {
                        $query->whereHas('anggotaSupervisor', function ($query) use ($supervisorId) {
                            $query->where('profile_dpl', $supervisorId);
                        });
                    }
                }
            })
            ->where(function ($query) use ($institusi_id) {
                if (Auth::user()->role != "Surveyor" && $institusi_id != 'semua' && $institusi_id != null) {
                    $query->whereHas('profile', function ($query) use ($institusi_id) {
                        $query->where('institusi_id', $institusi_id);
                    });
                }
            })
            ->where('nama_survey_id', $request->filter_nama_survey)->orderBy('updated_at', 'DESC')->paginate(50)->withQueryString();

        // dd($survey);

        // foreach ($survey[1]->namaSurvey->kategoriSoal as $kategori) {
        //     foreach ($kategori->soal as $soal) {
        //         dd($soal->jawabanSurvey[5]);
        //     }
        // }

        if (count($survey) == 0) {
            return back()->with('error', 'Data Tidak Ditemukan');
        }

        $surveyor = Profile::with(['user'])->whereHas('user', function ($user) {
            $user->where('role', '=', 'surveyor');
        })->where('id', $surveyor_id)->orderBy('nama_lengkap')->first();

        if (!$surveyor) {
            $surveyor = '';
        }

        $kategori = KategoriSoal::with(['soal'])->where('nama_survey_id', $request->filter_nama_survey)->get();

        $tanggal = Carbon::parse(Carbon::now())->translatedFormat('d F Y');

        $institusi = Institusi::where('id', $institusi_id)->first();

        $supervisor = Profile::where('id', $supervisorId)->first();

        $halaman = $request->page ?? '1';

        return Excel::download(new SurveyExport($kategori, $survey, $surveyor, $institusi, $supervisor, $halaman), $survey[0]->namaSurvey->nama . "-" . $tanggal . "-" . rand(1, 9999) . '-halaman-' . $halaman . '.xlsx');
    }
}
