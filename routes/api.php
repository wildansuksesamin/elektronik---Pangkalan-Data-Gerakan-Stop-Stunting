<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ApiAuthController;
use App\Http\Controllers\api\ApiSurveyController;
use App\Http\Controllers\api\ApiRespondenController;
use App\Http\Controllers\api\ApiProvinsiController;
use App\Http\Controllers\api\ApiKabupatenKotaController;
use App\Http\Controllers\api\ApiKecamatanController;
use App\Http\Controllers\api\ApiDesaKelurahanController;
use App\Http\Controllers\api\ApiSoalController;
use App\Http\Controllers\api\ApiNamaSurveyController;
use App\Http\Controllers\api\ApiJawabanSoalController;
use App\Http\Controllers\api\ApiJawabanSurveyController;
use App\Http\Controllers\api\ApiKategoriSoalController;
use App\Http\Controllers\api\ApiProfileController;
use App\Http\Controllers\api\ApiAkunController;
use App\Http\Controllers\api\ApiInstitusiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public Routes
Route::post('/login', [ApiAuthController::class, 'login']);

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::post('/logout', [ApiAuthController::class, 'logout']);

    // Surveyor
        // Survey
    Route::get('/surveyor/survey', [ApiSurveyController::class, 'index']);
    Route::post('/surveyor/survey', [ApiSurveyController::class, 'store']);
    Route::put('/surveyor/survey', [ApiSurveyController::class, 'update']);
    Route::delete('/surveyor/survey', [ApiSurveyController::class, 'destroy']);
    Route::get('/surveyor/survey/count', [ApiSurveyController::class, 'count']);
    Route::get('/connection', [ApiSurveyController::class, 'testConnection']);
    
    // Responden
    Route::get('/responden', [ApiRespondenController::class, 'index']);
    Route::post('/responden', [ApiRespondenController::class, 'store']);
    
    // Provinsi
    Route::get('/provinsi', [ApiProvinsiController::class, 'index']);

    // Kabupaten_kota
    Route::get('/kabupaten_kota', [ApiKabupatenKotaController::class, 'index']);

    // Kecamatan
    Route::get('/kecamatan', [ApiKecamatanController::class, 'index']);
    
    // Desa_kelurahan
    Route::get('/desa_kelurahan', [ApiDesaKelurahanController::class, 'index']);

    // Soal
    Route::get('/soal', [ApiSoalController::class, 'index']);

    // JawabanSoal
    Route::get('/jawaban_soal', [ApiJawabanSoalController::class, 'index']);
    
    // JawabanSurvey
    Route::get('/jawaban_survey', [ApiJawabanSurveyController::class, 'index']);
    Route::put('/jawaban_survey', [ApiJawabanSurveyController::class, 'update']);
    Route::post('/jawaban_survey', [ApiJawabanSurveyController::class, 'store']);
    Route::delete('/jawaban_survey', [ApiJawabanSurveyController::class, 'destroy']);
    
    // Kategori_soal
    Route::get('/kategori_soal', [ApiKategoriSoalController::class, 'index']);
    
    // nama_survey
    Route::get('/nama_survey', [ApiNamaSurveyController::class, 'index']);

    // Dashboard
        // Profile
    Route::get('/dashboard/profile', [ApiProfileController::class, 'show']);
    Route::put('/dashboard/profile', [ApiProfileController::class, 'update']);
        
        // Akun
    Route::get('/dashboard/akun', [ApiAkunController::class, 'show']);
    Route::put('/dashboard/akun', [ApiAkunController::class, 'update']);

    // Institusi
    Route::get('/institusi', [ApiInstitusiController::class, 'index']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
