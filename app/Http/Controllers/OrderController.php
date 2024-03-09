<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\OrderCollection as OrderCollection;
use App\Http\Resources\OrderResource as OrderResource;

class OrderController extends Controller
{
     /**
     * Display a listing of the User orders.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
       $userOrders = Order::where('userID', auth()->id())->get();
    //    dd( $userOrders);
       return new OrderCollection($userOrders);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        // dd($order);
        if($order->userID == auth()->id()){
             return new OrderResource($order);
         }else{
            return response()->json([
                'message' => 'The order you\'re trying to view doesn\'t seem to be yours, hmmmm.',
            ], 403);
         }

    }

    public function getorder(){
      dd('efdve');
      $jsonData = '{
         "data": [

           {
               "id": 13,
               "status": "unpaid",
               "total_price": "23.00",
               "number_of_items": 1,
               "customer": {
                   "id": 1,
                   "first_name": "AMINE",
                   "last_name": "TR"
               },
               "created_at": "2024-02-13 11:02:22",
               "updated_at": "2024-02-13 11:02:22"
           },

          
           {
               "id": 1,
               "status": "paid",
               "total_price": "3844.00",
               "number_of_items": 2,
               "customer": {
                   "id": 6,
                   "first_name": "gest2",
                   "last_name": "hmidouche"
               },
               "created_at": "2023-11-09 23:22:31",
               "updated_at": "2023-11-05 23:24:51"
           },
         
           
           {
               "id": 6,
               "status": "paid",
               "total_price": "3223.00",
               "number_of_items": 0,
               "customer": {
                   "id": 2,
                   "first_name": "gest",
                   "last_name": "user"
               },
               "created_at": "2024-03-07 20:53:09",
               "updated_at": "2024-03-07 20:53:09"
           }
       ],
       "links": {
           "first": "http://127.0.0.1:8000/api/orders?page=1",
           "last": "http://127.0.0.1:8000/api/orders?page=2",
           "prev": null,
           "next": "http://127.0.0.1:8000/api/orders?page=2"
       },
       "meta": {
           "current_page": 1,
           "from": 1,
           "last_page": 2,
           "links": [
               {
                   "url": null,
                   "label": "&laquo; Previous",
                   "active": false
               },
               {
                   "url": "http://127.0.0.1:8000/api/orders?page=1",
                   "label": "1",
                   "active": true
               },
               {
                   "url": "http://127.0.0.1:8000/api/orders?page=2",
                   "label": "2",
                   "active": false
               },
               {
                   "url": "http://127.0.0.1:8000/api/orders?page=2",
                   "label": "Next &raquo;",
                   "active": false
               }
           ],
           "path": "http://127.0.0.1:8000/api/orders",
           "per_page": 10,
           "to": 10,
           "total": 14
       }
      ];
   }';
     // Convert to JSON if needed
     $data = json_decode($jsonData, true);
        return response()->json($data);
     
    }

   
}
