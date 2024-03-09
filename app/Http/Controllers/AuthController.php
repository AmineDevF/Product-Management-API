<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
       public function __construct()
    {
       //  $this->middleware('guest')->except([
       //      'logout', 'home'
       //  ]);
       //  $this->middleware('auth')->only('logout', 'app.index','user.account');
       //  $this->middleware('verified');
    }

       public function index()
       {
              $user = auth()->user();
              // $items = Order::where('created_by', $user->id)->get();
              $orders = Order::where('created_by',$user->id)->get();
              // foreach ($orders as $order){
              //        dd($order->items[0]->product->name);
              //    foreach ($order->items as $item){
              //        // dd($item);
              // }    
              // }
              // dd($orders);
              $wishlistItems = Cart::instance("wishlist")->content();
              $totalorder = Order::where('created_by',$user->id)->count();
              $wishlistCount = Cart::instance('wishlist')->content()->count();
              $totalUnpaiedOrder = Order::where('created_by',$user->id)->where('status', 'unpaid')->count();
              return view("users.index",["user"=>$user,"totalorder"=>$totalorder ,"totalUnpaiedOrder"=>$totalUnpaiedOrder,"wishlistCount" => $wishlistCount , "orders"=>$orders , "wishlistItems"=>$wishlistItems]);
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
              $request->validate([
                     'name' => ['required', 'string', 'max:255'],
                     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                     'password' => ['required', 'confirmed',],
              ]);


              try {
                     $user =  User::create([
                            'name' => $request->name,
                            'email' => $request->email,
                            'password' => Hash::make($request->password),
                     ]);

                     $token =  $user->createToken('auth_token')->plainTextToken;
                     event(new Registered($user));
                     Auth::login($user);

                     // return redirect()->route('app.index');
                     return redirect()->route('verification.notice');
              } catch (\Exception $e) {

                     return redirect()->back()->withInput()->with('error', 'Unable to register right now.');
              }
       }
       public function login(Request $request)
       {


              $loginData = $request->validate([
                     'email' => 'email|required',
                     'password' => 'required'
              ]);

              if (!Auth::attempt($loginData)) {
                     // return response()->json([
                     //        'message' => 'Invalid login details'
                     // ], 401);

                     return redirect()->back()->withInput()->withErrors(['email' => 'Invalid login details']);
                     
              }

              $user = User::where('email', $request['email'])->firstOrFail();
              // dd($user->email_verified_at);
              $token = $user->createToken('auth_token')->plainTextToken;
              if(!$user->email_verified_at){
                     return redirect()->route('verification.notice');
              }else{

                     return redirect()->route('app.index');
              }
       }
       public function logout()
       {
              Auth::logout();

              // Optionally, you can redirect the user to a specific route after logout
              return redirect('/')->with('status', 'You have been logged out.');
       }

       public function delete(Request $request)
    {
        $user = $request->user(); 
        $user->delete();
        
        auth()->logout();

        return redirect('/')->with('message', 'Your account has been deleted.');
    }
}
