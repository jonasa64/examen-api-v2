<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $validatedRequest = $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users,email' ,
             'password' => 'required|confirmed'
         ]);
 
         $user = User::create([
             'name' => $validatedRequest['name'],
             'email' => $validatedRequest['email'],
             'password' => bcrypt($validatedRequest['password'])
         ]);
         $token =   $token = auth()->attempt([
            "email" => $validatedRequest['email'],
            "password" =>  $validatedRequest['password'],
        ]);
 
         return response()->json(['token' => auth('api')->tokenById($user->id), 'user' => $user], 201);
     }
 
     public function login(Request $request){
         $validatedRequest = $request->validate([
             'email' => 'required|email' ,
             'password' => 'required'
         ]);
 
 
 
         $user = User::where('email', $validatedRequest['email'])->first();
 
         if(!$user || !Hash::check($validatedRequest['password'], $user->password)){
             return \Response::json(['message' => 'Bad creds'], 401);
         }
 
         $token = auth()->attempt([
             "email" => $validatedRequest['email'],
             "password" =>  $validatedRequest['password'],
         ]);
         
         return response()->json(['token' => auth('api')->tokenById($user->id), 'user' => $user]);
 
     }
 
     public function logout(Request $request){
         auth()->logout();
         return response()->json(["data" => null], 204);
     }

     protected function respondWithToken($token)
     {
         return response()->json([
             'access_token' => auth('api')->tokenById($user->id),
             'token_type' => 'bearer',
             'expires_in' => "1h"
         ]);
     }
}
