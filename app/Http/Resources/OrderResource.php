<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CartItemCollection as CartItemCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
             'OrderID' => $this->id,
            'Ordered Products:' => json_decode($this->products),
            'Total Price' => $this->totalPrice,
            'name' => $this->name,
            'address' => $this->address,
            'transactionID' => $this->transactionID,
            ] ;
        // return parent::toArray($request);
    }
}
