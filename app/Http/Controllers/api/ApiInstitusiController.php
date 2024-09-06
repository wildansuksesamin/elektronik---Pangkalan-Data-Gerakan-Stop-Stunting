<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Institusi;

class ApiInstitusiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->id;
        $withTrashed = $request->withTrashed;

        if(!$withTrashed){
            if($id){
                $institusi = Institusi::where('id', $id)->orderBy('id', 'desc')->get();
            }else{
                $institusi = Institusi::orderBy('id', 'desc')->get();
            }
        }else {
            if($id){
                $institusi = Institusi::where('id', $id)->withTrashed()->orderBy('id', 'desc')->get();
            }else {
                $institusi = Institusi::withTrashed()->orderBy('id', 'desc')->get();
            }
        }
        if($institusi){
            return response([
                'message' => 'OK',
                'data' => $institusi
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
