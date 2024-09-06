<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ApiAkunController extends Controller
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
        $akun = User::where('id', '=', Auth::user()->id)->first();
        if($akun){
            return response([
                'message' => 'OK',
                'data' => $akun
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
        $user = User::find(Auth::user()->id);
        $request->validate([
            'username' => ['required', Rule::unique('users')->ignore($user->id)->withoutTrashed()]            
        ]);

        if($request->password == ''){
            $password = $user->password;
        } else{
            $password = bcrypt($request->password);
        }

        $data =[
            'username' => $request->username,
            'password' => $password
        ];

        if(User::where('id', $user->id)->update($data)){
            return response([
                'message' => 'account updated.'
            ], 200);
        } else {
            return response([
                'message' => 'failed to update account.'
            ], 500);
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
