<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ApiProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $profile = Profile::where('user_id', '=', Auth::user()->id)->first();
        if($profile){
            return response([
                'message' => 'OK',
                'data' => $profile
            ], 200);
        } else {
            return response([
                'message' => 'data not found.'
            ], 404);
        }
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
        $request->validate([
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'institusi_id' => 'required|numeric',
            'provinsi' => 'required',
            'kabupaten_kota' => 'required',
            'kecamatan' => 'required',
            'desa_kelurahan' => 'required',
            'nomor_hp' => 'required'
        ]);
        
        $data = [
            'user_id' => Auth::user()->id,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => date("Y-m-d", strtotime($request->tanggal_lahir)),
            'alamat' => $request->alamat,
            'institusi_id' => $request->institusi_id,
            'provinsi' => $request->provinsi,
            'kabupaten_kota' => $request->kabupaten_kota,
            'kecamatan' => $request->kecamatan,
            'desa_kelurahan' => $request->desa_kelurahan,
            'nomor_hp' => $request->nomor_hp,
            'email' => $request->email,
        ];

        $profile = Profile::where('user_id', '=', Auth::user()->id)->first();

        if($profile){
            if($profile->update($data)){
                return response([
                    'message' => 'profile updated.'
                ], 200);
            } else {
                return response([
                    'message' => 'failed to update profile.'
                ], 500);
            }
        } else{
            if(Profile::create($data)){
                return response([
                    'message' => 'Profile updated.'
                ], 200);
            } else {
                return response([
                    'message' => 'something wrong.'
                ], 500);
            }
        }
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
