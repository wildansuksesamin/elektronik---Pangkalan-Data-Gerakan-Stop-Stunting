<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Profile;

class ApiAuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

       $user = User::where('username', $credentials['username'])->first();

        if (Auth::attempt($credentials)) {
            if(Auth::user()->status == 1){
                if(Auth::user()->role == "Surveyor"){
                    //account is active
                    // Generate token
                    $token = $user->createToken('userToken')->plainTextToken;
    
                    // get profile data
                    $profile = Profile::where('user_id', '=', Auth::user()->id)->first();
    
                    return response([
                        'message' => 'OK',
                        'data' => $user,
                        'token' => $token,
                        'profileData' => $profile
                    ], 201);
                }else {
                    return response([
                        'message' => 'Access Forbidden. Only surveyor can use API'
                    ], 403);
                }
            } else{
                //account is disabled
                return response([
                    'message' => 'account disabled.'
                ], 401);
            }
        }
        //bad credentials
        return response([
            'message' => 'Bad credentials.'
        ], 401);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response([
            'message' => 'Logged out.'
        ]);
    }
}
