<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
       public function index()
       {
           return view("users.index");
       }
       public function admin()
       {
           return view("admin.index");
       }
       public function registerurl()
       {
           return view("auth.register");
       }
       public function loginurl()
       {
           return view("auth.login");
       }
       

       public function register(Request $request)
       {


              $validatedData = $request->validate([
                     
                     'name'=>'required|string',
                     'email'=>'required|string|unique:users,email',
                     'password' => 'required|string|confirmed',
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


                 $loginData = $request->validate([
                     'email' => 'email|required',
                     'password' => 'required'
                 ]);

              if (!Auth::attempt($loginData)) {
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
