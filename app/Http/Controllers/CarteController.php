<?php

namespace App\Http\Controllers;

// use App\Models\Cart as ModelsCart;

use App\Models\Product;
use Cart;
use Illuminate\Http\Request;

class CarteController extends Controller
{


    public function index()
    {
        $cartItems = Cart::instance('cart')->content();
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
    Cart::instance('cart')->update($request->rowId,$request->quantity);
    return redirect()->route('cart.index');
} 

public function removeItem(Request $request)
{
    $rowId = $request->rowId;
    Cart::instance('cart')->remove($rowId);
    return redirect()->route('cart.index');
}

}
