<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = Product::find($this->product_id);
     
        return [
            'productID' => $this->product_id,
            // 'SKU' => $product->sku,
            'price' => $product->prix,
            'Name' => $product->name,
            'Quantity' => $this->quantity,
        ];
        // return parent::toArray($request);
    }
}
