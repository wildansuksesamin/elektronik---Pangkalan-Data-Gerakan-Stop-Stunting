<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\JawabanSoal;
use Illuminate\Http\Request;

class ApiJawabanSoalController extends Controller
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
        
        if($id != null){
            // Get jawaban soal by id
            $data = JawabanSoal::where('id', $id)->orderBy('id', 'asc')->get();
        } else {
            if($soalId != null){
                $data = JawabanSoal::where('soal_id', $soalId)->orderBy('id', 'asc')->get();
            } else {
                // Get all soal
                $data = JawabanSoal::all();
            }
        }
        if($data){
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
