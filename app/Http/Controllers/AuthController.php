<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

       public function register(Request $request)
       {


              $validatedData = $request->validate([
                     'name' => 'required',
                     'email' => 'required',
                     'password' => 'required',
                     'phone' => 'required',
              ]);


              $user = User::create([
                     'name' => $validatedData['name'],
                     'email' => $validatedData['email'],
                     'password' => Hash::make($validatedData['password']),
                     'phone' => $validatedData['phone'],

              ]);

              $token = $user->createToken('auth_token')->plainTextToken;

              return response()->json([
                     'access_token' => $token,
                     'token_type' => 'Bearer',
              ]);
       }
       public function login(Request $request)
       {
              if (!Auth::attempt($request->only('email', 'password'))) {
                     return response()->json([
                            'message' => 'Invalid login details'
                     ], 401);
              }

              $user = User::where('email', $request['email'])->firstOrFail();

              $token = $user->createToken('auth_token')->plainTextToken;

              return response()->json([
                     'access_token' => $token,
                     'token_type' => 'Bearer',
              ]);
       }
}
