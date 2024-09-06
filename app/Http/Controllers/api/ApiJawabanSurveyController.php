<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\JawabanSurvey;
use App\Models\Survey;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToArray;

class ApiJawabanSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param $Id
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->id;
        $soalId = $request->soal_id;
        $kodeUnikSurvey = $request->kode_unik_survey;
        $kategoriSoalId = $request->kategori_soal_id;
        
        if($id != null){
            // Get jawaban soal by id
            $data = JawabanSurvey::where('id', $id)->orderBy('soal_id', 'asc')->get();
        } else {
            if($soalId != null){
                if($kodeUnikSurvey != null){
                    $data = JawabanSurvey::where('soal_id', $soalId)->where('kode_unik_survey', $kodeUnikSurvey)->orderBy('soal_id', 'asc')->get();
                } else {
                    $data = JawabanSurvey::where('soal_id', $soalId)->orderBy('soal_id', 'asc')->get();
                }
            } else if($kodeUnikSurvey != null) {
                if($kategoriSoalId != null){
                    $data = JawabanSurvey::where('kategori_soal_id', $kategoriSoalId)->where('kode_unik_survey', $kodeUnikSurvey)->orderBy('soal_id', 'asc')->get();
                } else {
                    $data = JawabanSurvey::where('kode_unik_survey', $kodeUnikSurvey)->orderBy('soal_id', 'asc')->get();
                }
            } else if($kategoriSoalId != null) {
                // Get jawabanSurvey by kanagoriSoalId
                $data = JawabanSurvey::where('kategori_soal_id', $kategoriSoalId)->orderBy('soal_id', 'asc')->get();
            } else {
                $data = JawabanSurvey::all();
            }
        }
        if(count($data) > 0){
            return response([
                'message' => 'OK',
                'data' => $data
            ], 200);
        } else {
            return response([
                'message' => 'data not found.'
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $kodeUnikSurvey = $request->all()[0]['kode_unik_survey'];
        
        $survey = Survey::where('kode_unik', $kodeUnikSurvey)->first();
        if($survey == null){
            return response([
                'message' => 'failed to create data. survey with kode_unik '. $kodeUnikSurvey . ' not found.'
            ], 400);
        }
        $data = JawabanSurvey::insert($request->all());
        
        if($data){
            return response([
                'message' => 'data created.',
                'data' => $request->all()
            ], 201);
        } else {
            return response([
                'message' => 'failed to create data.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $request->validate([
            'soal_id' => 'required|numeric',
            'kode_unik_survey' => 'required|numeric',
            'kategori_soal_id' => 'required|numeric'
        ]);

        $data = JawabanSurvey::find($id);
        $data->update($request->all());
        
        if($data){
            return response([
                'message' => 'data updated.'
            ], 201);
        } else {
            return response([
                'message' => 'failed to update data.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $soalId = $request->soal_id;
        $kodeUnikSurvey = $request->kode_unik_survey;
        $kategoriSoalId = $request->kategori_soal_id;

        if($id != null){
            $jawabanSurvey = JawabanSurvey::where('id', $id)->first();
        } else if($soalId != null){
            $jawabanSurvey = JawabanSurvey::where('soal_id', $soalId);
        } else if($kodeUnikSurvey != null){
            if($kategoriSoalId != null){
                $jawabanSurvey = JawabanSurvey::where('kode_unik_survey', $kodeUnikSurvey)->where('kategori_soal_id', $kategoriSoalId);
            } else {
                $jawabanSurvey = JawabanSurvey::where('kode_unik_survey', $kodeUnikSurvey);
            }
        } else if($kategoriSoalId != null){
            $jawabanSurvey = JawabanSurvey::where('kategori_soal_id', $kategoriSoalId);
        } else {
            return response([
                'message' => 'failed to delete data.'
            ], 500);
        }
        $jawabanSurvey->delete();

        if($jawabanSurvey){
            return response([
                'message' => 'Data deleted.'
            ], 200);
        } else {
            return response([
                'message' => 'failed to delete data.'
            ], 500);
        }
    }
}
