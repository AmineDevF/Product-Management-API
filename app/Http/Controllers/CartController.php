<?php

namespace App\Http\Controllers;

// use App\Http\Resources\CartItemCollection;
use App\Http\Resources\CartItemCollection as CartItemCollection;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
  /**
     * Store a newly created Cart in storage and return the data to the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::guard('api')->check()) {
          $userID = auth('api')->user()->getKey();
        //   dd( $userID) ;
        }

        $cart = Cart::create([
            // 'id' => md5(uniqid(rand(), true)),
            'key' => md5(uniqid(rand(), true)),
            'userID' => isset($userID) ? $userID : null,

        ]);
        return response()->json([
            'Message' => 'A new cart have been created for you!',
            'cartToken' => $cart->id,
            'cartKey' => $cart->key,
        ], 201);

    }

    
    
     // Display the specified Cart.
     
    
    public function show( Request $request , $key)
    {
        $cart = Cart::where('key' , $key)->first();
      
        if ($cart != null && $cart->key == $key ) {
            return response()->json([
                'cart' => $cart->id,
                'Items in Cart' => new CartItemCollection($cart->items),
            ], 200);

        } else {

            return response()->json([
                'message' => 'The CarKey you provided does not match the Cart Key for this Cart.',
            ], 400);
        }

    }

    public function destroy($cartKey, Request $request)
    {
        $cart = Cart::where('key' , $cartKey)->first();
        
        if ($cart != null && $cart->key == $cartKey ) {
            $cart->delete();
            return response()->json([
                'message' => 'The Cart you provided was deleted successfuly',
            ], 200);
        } else {

            return response()->json([
                'message' => 'The CarKey you provided does not match the Cart Key for this Cart.',
            ], 400);
        }

    }

     // Adds Products to the given Cart;
     
    
    public function addProducts(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cartKey' => 'required',
            'productID' => 'required',
            'quantity' => 'required|numeric|min:1|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $cartKey = $request->input('cartKey');
        $productID = $request->input('productID');
        $quantity = $request->input('quantity');

        //Check if the CarKey is Valid
        $cart = Cart::where('key' , $cartKey)->first();
        if ($cart->key == $cartKey) {
            //Check if the proudct exist or return 404 not found.
            try { $Product = Product::findOrFail($productID);} catch (ModelNotFoundException $e) {
                return response()->json([
                    'message' => 'The Product you\'re trying to add does not exist.',
                ], 404);
            }

            //check if the the same product is already in the Cart, if true update the quantity, if not create a new one.
            $cartItem = CartItem::where(['cart_id' => $cart->getKey(), 'product_id' => $productID])->first();
            $product = Product::where([ 'id' => $productID])->first();
            // dd($product->quantite);
            if ($cartItem) {
                $cartItem->quantity = $quantity;
                if($product->quantite >= $quantity){

                    CartItem::where(['cart_id' => $cart->getKey(), 'product_id' => $productID])->update(['quantity' => $quantity]);
                }else {
                    return response()->json([
                        'message' => ' ops! The Product quantity not available in stock .  ',
                    ], 404);
                }

            } else {
                if($product->quantite >= $quantity){

                    CartItem::create(['cart_id' => $cart->getKey(), 'product_id' => $productID, 'quantity' => $quantity]);
                }else{
                    return response()->json([
                        'message' => ' ops! The Product quantity not available in stock .  ',
                    ], 404);
                }
            }

            return response()->json(['message' => 'The Cart was updated with the given product information successfully'], 200);

        } else {

            return response()->json([
                'message' => 'The CarKey you provided does not match the Cart Key for this Cart.',
            ], 400);
        }

    }


    /**
     * checkout the cart Items and create and order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return void
     */
    public function checkout(Request $request , $cartKey)
    {

        if (Auth::guard('api')->check()) {
            $userID = auth('api')->user()->getKey();
        }

        $validator = Validator::make($request->all(), [
            // 'cartKey' => 'required',
            'name' => 'required',
            'adress' => 'required',
            'credit_card_number' => 'required',
            'expiration_year' => 'required',
            'expiration_month' => 'required',
            'cvc' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        // $cartKey = $request->input('cartKey');
        $cart = Cart::where('key' , $cartKey)->first();
        if ($cart->key == $cartKey) {
            $name = $request->input('name');
            $adress = $request->input('adress');
            $creditCardNumber = $request->input('credit_card_number');
            $TotalPrice = (float) 0.0;
            $items = $cart->items;

            foreach ($items as $item) {

                $product = Product::find($item->product_id);
                $price = $product->prix;
                $inStock = $product->quantite;
                if ($inStock >= $item->quantity) {

                    $TotalPrice = $TotalPrice + ($price * $item->quantity);

                    $product->quantite = $product->quantite - $item->quantity;
                    $product->save();
                } else {
                    return response()->json([
                        'message' => 'The quantity you\'re ordering of item ' . $item->id .
                        ' isn\'t available in stock, only ' . $inStock . ' units are in Stock, please update your cart to proceed',
                    ], 400);
                }
            }

            /**
             * Credit Card information should be sent to a payment gateway for processing and validation,
             * the response should be dealt with here, but since this is a dummy project we'll
             * just assume that the information is sent and the payment process was done succefully,
             */

            $PaymentGatewayResponse = true;
            $transactionID = md5(uniqid(rand(), true));

            if ($PaymentGatewayResponse) {
                $order = Order::create([
                    'products' => json_encode(new CartItemCollection($items)),
                    'totalPrice' => $TotalPrice,
                    'name' => $name,
                    'address' => $adress,
                    'userID' => isset($userID) ? $userID : null,
                    'transactionID' => $transactionID,
                ]);

                $cart->delete();

                return response()->json([
                    'message' => 'you\'re order has been completed succefully, thanks for shopping with us!',
                    'orderID' => $order->getKey(),
                ], 200);
            }
        } else {
            return response()->json([
                'message' => 'The CarKey you provided does not match the Cart Key for this Cart.',
            ], 400);
        }

    }


}
