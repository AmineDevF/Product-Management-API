<?php

namespace App\Http\Controllers;

// use App\Models\Cart as ModelsCart;

use App\Models\Coupon;
use App\Models\Product;
use Cart;
use Illuminate\Http\Request;

class CarteController extends Controller
{


    public function index()
    {

        $cartItems = Cart::instance('cart')->content();
        // foreach ($cartItems as $cart){
        // dd( $cart->qty);
        // }
       
        return view('cart.cart', compact('cartItems'));
    }
    
    public function addToCart(Request $request)
    {
        $product = Product::find($request->id);
        $price = $product->sale_price ? $product->sale_price : $product->regular_price;
        Cart::instance('cart')->add($product->id, $product->name, $request->quantity, $price)->associate('App\Models\Product');
        // return redirect()->back()->with('message', 'Success ! Item has been added successfully!');
        return response()->json(['status'=>200,'message'=>'success ! item successfully added to wishlst .']) ;
    }

    public function updateCart(Request $request)
{
    // dd($request);
    
    Cart::instance('cart')->update($request->rowid,$request->quantity);
    // return redirect()->route('cart.index');
    return response()->json(['status'=>200,'message'=>'quantity successfully updated .']) ;
} 

public function applyCoupon(Request $request)
{
    $originalPrice = Cart::instance('cart')->total();
    $couponCode = $request->input('couponCode');
    $price = 0 ;
    $coupon = Coupon::where('code',$couponCode)->first();
    if($coupon){

       $percentageDiscount = number_format(($coupon->value / $originalPrice) * 100,0); 
       return response()->json(['status'=>200, ["percentageDiscount" =>$percentageDiscount , "coupon"=> $coupon , "originalPrice"=>$originalPrice] , 'message'=>'coupon successfully applayed .']) ;
    }else{
        $price = Cart::instance('cart')->total();
        return response()->json(['status'=>400 ,'message'=>'coupon not applayed .',"price" =>$price ]) ;
    }

    
} 



public function removeItem(Request $request)
{
    $rowId = $request->rowId;
    Cart::instance('cart')->remove($rowId);
    return redirect()->route('cart.index');
}
public function clearCart(Request $request)
{
    $rowId = $request->rowId;
    Cart::instance('cart')->destroy();
    return redirect()->route('cart.index');
   
}

public function check(){
    return view('cart.checkout');
}

}
