<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Helpers\CartHelpers;
use App\Mail\NewOrderEmail;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mollie\Laravel\Facades\Mollie;
use Stripe\Price;
use Mail; 

class ShopController extends Controller
{



    public function index(Request $request)
    {
        $q = $request->input('q');

        // Retrieve pagination parameters
        $page = $request->query("page");
        $size = $request->query("size");

        // Set default pagination parameters if not provided
        if (!$page)
            $page = 1;
        if (!$size)
            $size = 12;

        // Retrieve sorting parameters
        $order = $request->query("order");
        if (!$order)
            $order = -1;
        $o_column = "";
        $o_order = "";

        // Determine sorting column and order
        switch ($order) {
            case 1:
                $o_column = "created_at";
                $o_order = "DESC";
                break;
            case 2:
                $o_column = "created_at";
                $o_order = "ASC";
                break;
            case 3:
                $o_column = "regular_price";
                $o_order = "ASC";
                break;
            case 4:
                $o_column = "regular_price";
                $o_order = "DESC";
                break;
            default:
                $o_column = "id";
                $o_order = "DESC";
        }

        // Retrieve price range parameters
        $prange = $request->query("prange");
        if (!$prange)
            $prange = "0,500";
        $from  = explode(",", $prange)[0];
        $to  = explode(",", $prange)[1];

        // Retrieve brand and category parameters
        $brands = Brand::orderBy('name', 'ASC')->get();
        $q_brands = $request->query("brands");
        $categories = Category::orderBy("name", "ASC")->get();
        $q_categories = $request->query("categories");

        // Initialize product query
        $productsQuery = Product::query();

        // Apply search by product name if query is provided
        if ($q) {
            $productsQuery->where('name', 'like', '%' . $q . '%');
        }

        // Apply brand filter
        if ($q_brands) {
            $productsQuery->whereIn('brand_id', explode(',', $q_brands))
                ->orWhereRaw("'" . $q_brands . "'=''");
        }

        // Apply category filter
        if ($q_categories) {
            $productsQuery->whereIn('category_id', explode(',', $q_categories))
                ->orWhereRaw("'" . $q_categories . "'=''");
        }

        // Apply price range filter
        $productsQuery->whereBetween('regular_price', array($from, $to));

        // Apply sorting
        $productsQuery->orderBy('created_at', 'DESC')->orderBy($o_column, $o_order);

        // Paginate results
        $products = $productsQuery->paginate($size);
        //     dd($products);
        return view('products.shop', [
            'products' => $products,
            'page' => $page,
            'size' => $size,
            'order' => $order,
            'brands' => $brands,
            'q_brands' => $q_brands,
            'categories' => $categories,
            'q_categories' => $q_categories,
            'from' => $from,
            'to' => $to,
            'query' => $q // Pass the search query to the view
        ]);
    }




    public function productDetials($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $rproduct = Product::where('slug', '!=', $slug)->inRandomOrder('id')->get()->take(8);
        // dd($product) ; 
        return view('products.details', ['product' => $product, 'rproducts' => $rproduct]);
    }
    public function search(Request $request)
    {
        $q = $request->input('q');

        // Retrieve pagination parameters
        $page = $request->query("page");
        $size = $request->query("size");

        // Set default pagination parameters if not provided
        if (!$page)
            $page = 1;
        if (!$size)
            $size = 12;

        // Retrieve sorting parameters
        $order = $request->query("order");
        if (!$order)
            $order = -1;
        $o_column = "";
        $o_order = "";

        // Determine sorting column and order
        switch ($order) {
            case 1:
                $o_column = "created_at";
                $o_order = "DESC";
                break;
            case 2:
                $o_column = "created_at";
                $o_order = "ASC";
                break;
            case 3:
                $o_column = "regular_price";
                $o_order = "ASC";
                break;
            case 4:
                $o_column = "regular_price";
                $o_order = "DESC";
                break;
            default:
                $o_column = "id";
                $o_order = "DESC";
        }

        // Retrieve price range parameters
        $prange = $request->query("prange");
        if (!$prange)
            $prange = "0,500";
        $from  = explode(",", $prange)[0];
        $to  = explode(",", $prange)[1];

        // Retrieve brand and category parameters
        $brands = Brand::orderBy('name', 'ASC')->get();
        $q_brands = $request->query("brands");
        $categories = Category::orderBy("name", "ASC")->get();
        $q_categories = $request->query("categories");

        // Initialize product query
        $productsQuery = Product::query();

        // Apply search by product name if query is provided
        if ($q) {
            $productsQuery->where('name', 'like', '%' . $q . '%');
        }

        // Apply brand filter
        if ($q_brands) {
            $productsQuery->whereIn('brand_id', explode(',', $q_brands))
                ->orWhereRaw("'" . $q_brands . "'=''");
        }

        // Apply category filter
        if ($q_categories) {
            $productsQuery->whereIn('category_id', explode(',', $q_categories))
                ->orWhereRaw("'" . $q_categories . "'=''");
        }

        // Apply price range filter
        $productsQuery->whereBetween('regular_price', array($from, $to));

        // Apply sorting
        $productsQuery->orderBy('created_at', 'DESC')->orderBy($o_column, $o_order);

        // Paginate results
        $products = $productsQuery->paginate($size);

        return view('products.shop', [
            'products' => $products,
            'page' => $page,
            'size' => $size,
            'order' => $order,
            'brands' => $brands,
            'q_brands' => $q_brands,
            'categories' => $categories,
            'q_categories' => $q_categories,
            'from' => $from,
            'to' => $to,
            'query' => $q // Pass the search query to the view
        ]);
    }


    public function getCartAndWishlistCount()
    {
        $cartCount = Cart::instance('cart')->content()->count();
        $wishlistCount = Cart::instance('wishlist')->content()->count();

        return response()->json(["status" => 200, "cartCount" => $cartCount, "wishlistCount" => $wishlistCount]);
    }

    public function getCartTotal()
    {
        $total =  Cart::instance('cart')->total();
        $tax = Cart::instance('cart')->tax();
        $subTotal = Cart::instance('cart')->subtotal();

        return response()->json(["status" => 200, "total" => $total, "tax" => $tax, "subTotal" => $subTotal]);
    }

  
    public function checkout(Request $request)
    {

        $couponCode = $request->totadl;
        $coupon_price = Coupon::where(['code' => $couponCode])->first();

        $t = 0;
        $totalcart =  Cart::instance('cart')->total();
        $subtotalcart =  Cart::instance('cart')->subtotal();
        $taxcart =  Cart::instance('cart')->tax();
        $total = str_replace(",", "", $totalcart);
        if ($couponCode != null) {
            $t += ($total - $coupon_price['value']);
        } else {
            $t += ($total);
        }

        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" =>  number_format($t, 2, '.', ''),
            ],
            "description" => "Order #12345",
            "redirectUrl" => route('checkout.success'),
            // "webhookUrl" => route('webhooks.mollie'),
            "metadata" => [
                "order_id" => "12345",
            ],
        ]);
        // dd($coupon_price['value']);
        $orderData = [
            'total' => $payment->amount->value,
            'subtotal' =>  $subtotalcart,
            'status' => OrderStatus::Unpaid,
            'discount' => $coupon_price ? $coupon_price['value'] : 0,
            'tax' =>  $taxcart,
            'created_by' =>  auth()->id(),
            'updated_by' =>  auth()->id(),
        ];

        $order = Order::create($orderData);

        // Create Order Items
        [$products, $cartItems] = CartHelpers::getProductsAndCartItems();
        // dd($cartItems);
        foreach ($cartItems as $cartItem) {
            // $orderItem['order_id'] = $order->id;
            $orderItems = [
                "order_id" => $order->id,
                'product_id' => $cartItem->id,
                'price' => $cartItem->price,
                'quantity' => $cartItem->qty
            ];
            OrderItem::create($orderItems);
        }

        // Create Payment
        $paymentData = [
            'order_id' => $order->id,
            'amount' => number_format($t, 2, '.', ''),
            'status' => PaymentStatus::Pending,
            'type' => 'cc',
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
            'session_id' => $payment->id
        ];
        Transaction::create($paymentData);
      

        // store payment id in session 
        session()->put('paymentId', $payment->id);
        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

   
    public function success()
    {
        $paymentId = session()->get('paymentId');
        //dd($paymentId);
        $payment = Mollie::api()->payments->get($paymentId);
        $transaction = Transaction::where('session_id',$paymentId)->first();
        // dd($tr->order->status);    
        if ($payment->isPaid()) {
          
            $order = $transaction->order ;

          
            if ($order->status === 'unpaid') {
                $order->status = 'paid';
                $order->created_by = auth()->id();
                $order->updated_by = auth()->id();
                $order->save();
                $transaction->status = 'paid';
                $transaction->save();

               
            [$products, $cartItems] = CartHelpers::getProductsAndCartItems();
                
            foreach ($cartItems as $cartItem ){
              $prdID =  $cartItem->id;
              $product =  Product::where('id',$prdID)->first();
              $product->quantity = $product->quantity - $cartItem->qty;
              $product->save();
               
            }
            $items = $order->items;
            
            // send mail after payment confirmation 
            $adminUsers = User::where('role', "admin")->get();
            $userEmail = auth()->user()->email;
            Mail::to($userEmail)->send(new NewOrderEmail($order , $items , $transaction));
           
          
            Cart::instance('cart')->destroy();
         // delete cart history
 }
            return view('products.success', ['items' => $items, 'order'=> $order , 'transaction'=>$transaction]);

        } else {

            return redirect()->route('checkout.cancel');
        }
    }
    
    public function cancel()
    {
        echo "Payment is cancelled.";
    }
    public function checkout2(Request $request)
    {
        // dd($request);
        $tax = Cart::instance('cart')->tax();

        [$products, $cartItems] = CartHelpers::getProductsAndCartItems();
        // dd($cartItems);
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // $products = Product::take(2)->get();
        $lineItems = [];
        $totalPrice = 0;
        $totalWithTax = 0;
        $prdcount = $products->count();
        foreach ($products as $product) {
            $product_data[] = [

                'name' => $product->name,
                'images' => ['http://127.0.0.1:8000/assets/images/fashion/product/front/24.jpg'],

            ];
        }
        $lineItems[] = [



            'price_data' => [
                'currency' => 'usd',

                'product_data' => [

                    'name' => "PRd 2",
                    'images' => ['http://127.0.0.1:8000/assets/images/fashion/product/front/24.jpg'],
                    'price_data' => 321,
                    'name' => "prd 2",
                    'images' => ['http://127.0.0.1:8000/assets/images/fashion/product/front/24.jpg'],

                ],

                'unit_amount' => 33 * 100, // Total price including tax and discount in cents
            ],
            'quantity' => 1,


        ];

        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
                'cancel_url' => route('checkout.cancel', [], true),
        ]);

        return redirect($session->url);
    }

    public function checkout1(Request $request)
    {
        // dd($request);
        $tax = Cart::instance('cart')->tax();

        [$products, $cartItems] = CartHelpers::getProductsAndCartItems();
        // dd($cartItems);
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));


        [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => 'amine',
                    'images' => ['http://127.0.0.1:8000/assets/images/fashion/product/front/24.jpg'],
                ],
                'unit_amount' => (234) * 100, // Total price including tax and discount in cents
            ]
        ];



        // $products = Product::take(2)->get();
        $lineItems = [];
        $totalPrice = 0;
        $totalWithTax = 0;
        $prdcount = $products->count();
        //   dd($prdcount);
        foreach ($products as $product) {
            $qty =  $cartItems[$product->id]->qty;
            // $taxt =  $cartItems[$product->id];
            $taxprice = Cart::instance('cart')->tax();
            $taxPerProduct = number_format(($taxprice /  ($prdcount * $product->quantity)), 2);

            // dd($taxPerProduct);  
            $finalPrice = $product->sale_price ? $product->sale_price : $product->regular_price;
            $totalWithTax += $finalPrice;
            $lineItems[] = [
                // 'payment_method_types' => ['card'],
                // 'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->name,
                        'images' => ['http://127.0.0.1:8000/assets/images/fashion/product/front/24.jpg'],
                    ],
                    'unit_amount' => ($product->regular_price + $taxPerProduct) * 100, // Total price including tax and discount in cents
                ],
                'quantity' => $qty,


            ];
        }
        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true) . "?session_id={CHECKOUT_SESSION_ID}",
            //     'cancel_url' => route('checkout.cancel', [], true),
        ]);

        return redirect($session->url);
    }
}
