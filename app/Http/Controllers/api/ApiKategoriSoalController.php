<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\KategoriSoal;
use Illuminate\Http\Request;

class ApiKategoriSoalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->id;
        $namaSurveyId = $request->nama_survey_id;
        if($id != null){
            // get kategori soal by id
            $data = KategoriSoal::where('id', $id)->orderBy('id', 'asc')->get();
        } else if($namaSurveyId != null){
            $data = KategoriSoal::where('nama_survey_id', $namaSurveyId)->orderBy('id', 'asc')->get();
        }
        else{
            // get all data kategori soal
            $data = KategoriSoal::all();
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
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
