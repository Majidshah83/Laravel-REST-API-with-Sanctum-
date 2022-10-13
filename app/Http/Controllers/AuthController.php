<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\RegisterRequest;
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
    public function logOut(Request $request)
    {
        Auth()->user()->tokens()->delete();
        return [
            'Message'=>'Logg out',
        ];

    }
}
