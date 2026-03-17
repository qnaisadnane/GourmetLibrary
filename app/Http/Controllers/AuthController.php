<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
             $request->validate([
                'name'=>'required',
                'email'=>'required |email | unique:users',
                'password'=>'required|min:8'
             ]);
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]);

             $token = $user->createToken('api-token')->plainTextToken;

             return [
                'user'=>$user,
                'token'=>$token
             ];
    }
    public function login(Request $request){
            $user = User::where('email',$request->email)->first();

            if(!$user || !Hash::check($request->password,$user->password)){
            return response()->json([
                'message'=>'Invalid user'
            ],401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'user'=>$user,
            'token'=>$token
        ];
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return ['message'=>'logged out'];
    }
}
