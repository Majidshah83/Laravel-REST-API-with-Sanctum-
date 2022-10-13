<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Response;
use Laravel\Sanctum\HasApiTokens;
class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {

        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();
        $token=$user->createToken('mytoken')->plainTextToken;
        $response=[
            'user'=>$user,
            'token'=>$token
        ];
        return $response;
    }
    public function login(LoginRequest $request)
    {

    if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
    }
        $user=User::where('email',$request->email)->first();
        $token=$user->createToken('mytoken')->plainTextToken;
        $response=[
            'status' => true,
            'message' => 'User Logged In Successfully',
            'user'=>$user,
            'token'=>$token
        ];
        return $response;
    }
    public function logOut(Request $request)
    {
        Auth()->user()->tokens()->delete();
        return [
            'Message'=>'Logg out',
        ];

    }
}