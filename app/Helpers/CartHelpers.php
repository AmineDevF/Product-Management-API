<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Arr;
use Cart ;
/**
 * Class Cart
 *
 * @author  amine hmidouche <amine.devf@gmail.com>
 * @package App\Helpers
 */
class CartHelpers
{

    /**
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * @author amine hmidouche <amine.devf@gmail.com>
     */
    public static function getProductsAndCartItems(): array|\Illuminate\Database\Eloquent\Collection
    {
        $cartItems = Cart::instance('cart')->content();
        
        $ids = Arr::pluck($cartItems, 'id');
        $products = Product::query()->whereIn('id', $ids)->get();
        $cartItems = Arr::keyBy($cartItems, 'id');
        // dd($cartItems);
        return [$products, $cartItems];
    }
}
