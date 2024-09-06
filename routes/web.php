<?php

use App\Models\Institusi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\SurveyorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\masterData\ImportAkunController;
use App\Http\Controllers\survey\SurveyController;
use App\Http\Controllers\masterData\UserController;
use App\Http\Controllers\masterSoal\SoalController;
use App\Http\Controllers\masterData\ProfileController;
use App\Http\Controllers\survey\ExportSurveyController;
use App\Http\Controllers\survey\ImportSurveyController;
use App\Http\Controllers\masterData\InstitusiController;
use App\Http\Controllers\masterData\RespondenController;
use App\Http\Controllers\masterSoal\NamaSurveyController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\masterSoal\KategoriSoalController;
use App\Http\Controllers\masterData\ImportRespondenController;
use App\Http\Controllers\masterData\wilayah\ProvinsiController;
use App\Http\Controllers\masterData\wilayah\KabupatenKotaController;
use App\Http\Controllers\masterData\wilayah\KecamatanController;
use App\Http\Controllers\masterData\wilayah\DesaKelurahanController;
use App\Http\Controllers\masterData\LokasiSurveyController;
use App\Http\Controllers\masterData\supervisorDpl\AnggotaSupervisorController;
use App\Http\Controllers\masterData\supervisorDpl\InstitusiSupervisorDplController;
use App\Http\Controllers\masterData\supervisorDpl\LokasiSurveySupervisorController;
use App\Http\Controllers\masterData\supervisorDpl\SupervisorDplController;
use App\Http\Controllers\surveySupervisor\SurveySupervisorController;
use App\Http\Controllers\surveySupervisor\SurveySupervisorLokasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages/landingPage');
});


Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/cekLogin', [AuthController::class, 'cekLogin']);

// Role Admin dan Surveyor
Route::group(['middleware' => ['auth']], function () {
    Route::get('/edit-profile-account', [DashboardController::class, 'editProfileAccount'])->name('editProfileAccount');
    Route::post('/update-account', [DashboardController::class, 'updateAccount'])->name('updateAccount');
    Route::post('/update-profile', [DashboardController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/statistik', [DashboardController::class, 'statistikSurvey'])->name('dashboardStatistik');
    Route::get('/dashboard/survey-belum-selesai', [DashboardController::class, 'surveyBelumSelesai'])->name('surveyBelumSelesai');


    Route::get('/lengkapi-profile', function () {
        $institusi = Institusi::latest()->get();
        return view('pages.lengkapiProfile', compact('institusi'));
    })->name('lengkapiProfile');

    Route::get('/exportSurvey', [ExportSurveyController::class, 'index']);
    Route::get('/exportSurvey/exportExcel', [ExportSurveyController::class, 'exportSurvey']);
    Route::get('/importSurvey', [ImportSurveyController::class, 'index']);
    Route::post('/importSurvey/store', [ImportSurveyController::class, 'store']);
    Route::get('/survey/lihat-survey/{survey}', [SurveyController::class, 'lihatSurvey']);
    Route::post('/survey/cek-pilih-responden', [SurveyController::class, 'cekPilihResponden']);
    Route::get('/survey/daftar-survey', [SurveyController::class, 'index']);
    Route::delete('/survey/lihat-survey/{survey}', [SurveyController::class, 'delete']);
});




// Role Admin
Route::group(['middleware' => ['role:Admin|Sub Admin']], function () {
    Route::resource('/wilayah-provinsi', ProvinsiController::class);
    Route::put('/status-provinsi/{wilayah_provinsi}', [ProvinsiController::class, 'status']);
    Route::resource('/wilayah-kabupaten/{wilayah_provinsi}', KabupatenKotaController::class)->parameters([
        '{wilayah_provinsi}' => 'kabupatenKota'
    ]);
    Route::put('/status-kabupaten/{kabupatenKota}', [KabupatenKotaController::class, 'status']);
    Route::resource('/wilayah-kecamatan/{kabupatenKota}', KecamatanController::class)->parameters([
        '{kabupatenKota}' => 'kecamatan'
    ]);
    Route::put('/status-kecamatan/{kecamatan}', [KecamatanController::class, 'status']);
    Route::resource('/wilayah-desa/{kecamatan}', DesaKelurahanController::class)->parameters([
        '{kecamatan}' => 'desaKelurahan'
    ]);
    Route::put('/status-desa/{desaKelurahan}', [DesaKelurahanController::class, 'status']);



    Route::get('importAkun', [ImportAkunController::class, 'index']);
    Route::post('importAkun', [ImportAkunController::class, 'importData']);
    Route::resource('/user', UserController::class);
    Route::resource('/profile', ProfileController::class);
    Route::resource('/institusi', InstitusiController::class);
    Route::post('responden/export', [RespondenController::class, 'export']);
    Route::resource('/responden', RespondenController::class)->parameters([
        'responden' => 'responden'
    ]);
    Route::post('/importResponden/store', [ImportRespondenController::class, 'store']);


    Route::put('/namaSurvey/statusAktif/{namaSurvey}', [NamaSurveyController::class, 'statusAktif']);
    Route::resource('/namaSurvey', NamaSurveyController::class);
    Route::resource("/kategoriSoal/{namaSurvey}", KategoriSoalController::class)->parameters([
        '{namaSurvey}' => 'kategoriSoal'
    ]);
    Route::resource("/soal/{kategoriSoal}", SoalController::class)->parameters([
        '{kategoriSoal}' => 'soal'
    ]);

    Route::resource('/lokasi-survey', LokasiSurveyController::class); //// NEW

    // DPL
    Route::get('/institusi-supervisor-dpl', [InstitusiSupervisorDplController::class, 'index']);
});

Route::group(['middleware' => ['role:Admin|Sub Admin|Institusi']], function () {
    Route::get('/supervisor-dpl/{institusi}', [SupervisorDplController::class, 'index']);
});

Route::group(['middleware' => ['role:Admin|Sub Admin|Institusi|Supervisor']], function () {
    Route::resource('/anggota-supervisor-dpl/{lokasiSurveySupervisor}', AnggotaSupervisorController::class)->parameters([
        '{lokasiSurveySupervisor}' => 'anggotaSupervisor'
    ]);
    Route::resource('/lokasi-survey-supervisor-dpl/{dpl}', LokasiSurveySupervisorController::class)->parameters([
        '{dpl}' => 'lokasiSurvey'
    ]);
});

// supervisor DPL
Route::group(['middleware' => ['supervisor']], function () {
    Route::get('/survey-supervisor/lokasi-survey', [SurveySupervisorLokasiController::class, 'index']);
    Route::get('/survey-supervisor/survey/{lokasiSurveySupervisor}', [SurveySupervisorController::class, 'index']);
});


// Role Surveyor
Route::group(['middleware' => ['surveyor']], function () {
    Route::post('/survey/tambah-responden', [RespondenController::class, 'insertResponden'])->name('tambahResponden');
    Route::get('/survey/pilih-responden', [SurveyController::class, 'pilihResponden'])->name('pilihResponden');
    Route::get('/survey/pertanyaan-survey/{survey}/{kategori}', [SurveyController::class, 'pertanyaanSurvey']);
    Route::post('/survey/cek-jawaban/{survey}', [SurveyController::class, 'cekJawabanSurvey']);
});



// Wilayah Indonesia
Route::get('/provinsi', [ListController::class, 'listProvinsi'])->name('listProvinsi');
Route::get('/kabupaten-kota', [ListController::class, 'listKabupatenKota'])->name('listKabupatenKota');
Route::get('/kecamatan', [ListController::class, 'listKecamatan'])->name('listKecamatan');
Route::get('/desa-kelurahan', [ListController::class, 'listDesaKelurahan'])->name('listDesaKelurahan');
Route::get('/list/lokasi-survey', [ListController::class, 'listLokasiSurvey']);
Route::get('/list/surveyor', [ListController::class, 'listSurveyor']);
Route::get('/list/supervisor', [ListController::class, 'listSupervisor']);

Route::post('/namaSurvey/{namaSurvey}/duplikat', [NamaSurveyController::class, 'duplikat']);
