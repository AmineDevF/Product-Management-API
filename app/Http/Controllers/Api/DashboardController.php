<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function activeCustomers()
    {
        return User::where('role', '!=', 'admin')->count();
    }

    public function activeProducts()
    {
        return Product::where('stock_status', '=', 'instock')->count();
    }

    public function paidOrders()
    {
        $fromDate = $this->getFromDate();
        $query = Order::query()->where('status', OrderStatus::Paid->value);

        if ($fromDate) {
            $query->where('created_at', '>', $fromDate);
        }

        return $query->count();
    }

    public function totalIncome()
    {
        // $fromDate = $this->getFromDate();
        $query = Order::query()->where('status', OrderStatus::Paid->value);

        return round($query->sum('total'));
    }

    public function ordersByCountry()
    {
        // $fromDate = $this->getFromDate();
        // $query = Order::query()
        //     ->select(['c.name', DB::raw('count(orders.id) as count')])
        //     ->join('users', 'created_by', '=', 'users.id')
        //     ->join('customer_addresses AS a', 'users.id', '=', 'a.customer_id')
        //     ->join('countries AS c', 'a.country_code', '=', 'c.code')
        //     ->where('status', OrderStatus::Paid->value)
        //     ->where('a.type', AddressType::Billing->value)
        //     ->groupBy('c.name')
        //     ;

        // if ($fromDate) {
        //     $query->where('orders.created_at', '>', $fromDate);
        // }

        // return $query->get();

        return response()->json([]);
       
    }

    public function latestCustomers()
    {
        // return Customer::query()
        //     ->select(['id', 'first_name', 'last_name', 'u.email', 'phone', 'u.created_at'])
        //     ->join('users AS u', 'u.id', '=', 'customers.user_id')
        //     ->where('status', CustomerStatus::Active->value)
        //     ->orderBy('created_at', 'desc')
        //     ->limit(5)
        //     ->get();
            // return User::where('role', '!=', 'admin')->orderBy('created_at', 'desc')
            // ->limit(5)
            // ->get();

            $json = '[
                {
                    "id": 14,
                    "first_name": "testbilal",
                    "last_name": "bilal",
                    "email": "bilal@gmail.com",
                    "phone": "0626267852",
                    "created_at": "2024-02-19T09:41:16.000000Z"
                },
                {
                    "id": 12,
                    "first_name": "gestysn",
                    "last_name": "",
                    "email": "ysin@gmail.com",
                    "phone": null,
                    "created_at": "2024-02-13T15:54:21.000000Z"
                },
                {
                    "id": 6,
                    "first_name": "gest2",
                    "last_name": "hmidouche",
                    "email": "gest2@gmail.com",
                    "phone": "08383737337",
                    "created_at": "2023-11-05T23:07:37.000000Z"
                }
            ]';
            
            $data = json_decode($json, true);
            
            return response()->json($data);
            
            
    }

    public function ordrin(){
        $data = [
            [
                "id" => 14,
                "status" => "unpaid",
                "total_price" => "5541.00",
                "number_of_items" => 3,
                "customer" => [
                    "id" => 14,
                    "first_name" => "testbilal",
                    "last_name" => "bilal"
                ],
                "created_at" => "2024-02-19 09:45:04",
                "updated_at" => "2024-02-19 09:45:04"
            ],
            [
                "id" => 11,
                "status" => "shipped",
                "total_price" => "5918.00",
                "number_of_items" => 2,
                "customer" => [
                    "id" => 1,
                    "first_name" => "AMINE",
                    "last_name" => "TR"
                ],
                "created_at" => "2024-02-13 10:49:49",
                "updated_at" => "2024-02-13 19:26:42"
            ],
            [
                "id" => 13,
                "status" => "unpaid",
                "total_price" => "23.00",
                "number_of_items" => 1,
                "customer" => [
                    "id" => 1,
                    "first_name" => "AMINE",
                    "last_name" => "TR"
                ],
                "created_at" => "2024-02-13 11:02:22",
                "updated_at" => "2024-02-13 11:02:22"
            ],
            // Include other data items here...
        ];
        
        $links = [
            "first" => "http://127.0.0.1:8000/api/orders?page=1",
            "last" => "http://127.0.0.1:8000/api/orders?page=2",
            "prev" => null,
            "next" => "http://127.0.0.1:8000/api/orders?page=2"
        ];
        
        $meta = [
            "current_page" => 1,
            "from" => 1,
            "last_page" => 2,
            "links" => [
                [
                    "url" => null,
                    "label" => "&laquo; Previous",
                    "active" => false
                ],
                [
                    "url" => "http://127.0.0.1:8000/api/orders?page=1",
                    "label" => "1",
                    "active" => true
                ],
                [
                    "url" => "http://127.0.0.1:8000/api/orders?page=2",
                    "label" => "2",
                    "active" => false
                ],
                [
                    "url" => "http://127.0.0.1:8000/api/orders?page=2",
                    "label" => "Next &raquo;",
                    "active" => false
                ]
            ],
            "path" => "http://127.0.0.1:8000/api/orders",
            "per_page" => 10,
            "to" => 10,
            "total" => 14
        ];
        
        $result = [
            "data" => $data,
            "links" => $links,
            "meta" => $meta
        ];
           return response()->json($result);
       
       
      }

    public function latestOrders()
    {
        // return OrderResource::collection(
        //     Order::query()
        //         ->select(['o.id', 'o.total_price', 'o.created_at', DB::raw('COUNT(oi.id) AS items'),
        //             'c.user_id', 'c.first_name', 'c.last_name'])
        //         ->from('orders AS o')
        //         ->join('order_items AS oi', 'oi.order_id', '=', 'o.id')
        //         ->join('customers AS c', 'c.user_id', '=', 'o.created_by')
        //         ->where('o.status', OrderStatus::Paid->value)
        //         ->limit(10)
        //         ->orderBy('o.created_at', 'desc')
        //         ->groupBy('o.id', 'o.total_price', 'o.created_at', 'c.user_id', 'c.first_name', 'c.last_name')
        //         ->get()
        // );
        $json = '{
            "data": [
                {
                    "id": 3,
                    "total_price": "3232.00",
                    "created_at": "3 months ago",
                    "items": 1,
                    "user_id": 6,
                    "first_name": "gest2",
                    "last_name": "hmidouche"
                },
                {
                    "id": 2,
                    "total_price": "6776.00",
                    "created_at": "3 months ago",
                    "items": 3,
                    "user_id": 6,
                    "first_name": "gest2",
                    "last_name": "hmidouche"
                },
                {
                    "id": 1,
                    "total_price": "3844.00",
                    "created_at": "3 months ago",
                    "items": 2,
                    "user_id": 6,
                    "first_name": "gest2",
                    "last_name": "hmidouche"
                }
            ]
        }';
        
        $data = json_decode($json, true);

        return response()->json($data);
    }
    public function view($order){

        $jsonData = '{
            "id": 14,
            "status": "unpaid",
            "total_price": "5541.00",
            "items": [
                {
                    "id": 11,
                    "unit_price": "5454.00",
                    "quantity": 1,
                    "product": {
                        "id": 10,
                        "slug": "jh",
                        "title": "jh",
                        "image": "http://localhost:8000/storage/images/aRQmQ1nvy4aVLr5o/7x1MC7dyT0hI0Cdv.jpg"
                    }
                },
                {
                    "id": 12,
                    "unit_price": "23.00",
                    "quantity": 1,
                    "product": {
                        "id": 12,
                        "slug": "test-prde",
                        "title": "test  prde",
                        "image": "http://localhost:8000/storage/images/MQOQz0J2TUwcP8no/wdDxtPpCg7XcxBoU.jpg"
                    }
                },
                {
                    "id": 13,
                    "unit_price": "32.00",
                    "quantity": 2,
                    "product": {
                        "id": 15,
                        "slug": "deeeeeeeeeeee",
                        "title": "DEEEEEEEEEEEE",
                        "image": "http://localhost:8000/storage/images/tmGMJVLW9uZhn1d8/FSbEIkgCHos3vlTY.jpg"
                    }
                }
            ],
            "customer": {
                "id": 14,
                "email": "bilal@gmail.com",
                "first_name": "testbilal",
                "last_name": "bilal",
                "phone": "0626267852",
                "shippingAddress": {
                    "id": 4,
                    "address1": "Fouarat APP 5 N°5",
                    "address2": "kezkjdhj",
                    "city": "KENITRA",
                    "state": "2R4234RGFDS",
                    "zipcode": "14000",
                    "country": "maroc"
                },
                "billingAddress": {
                    "id": 5,
                    "address1": "test",
                    "address2": "yettt",
                    "city": "keni",
                    "state": "2",
                    "zipcode": "3444",
                    "country": "canada"
                }
            },
            "created_at": "2024-02-19 09:45:04",
            "updated_at": "2024-02-19 09:45:04"
        }';
        
        $phpArray = json_decode($jsonData, true);
        
        return response()->json($phpArray);
      }
    private function getFromDate()
    {
        $request = \request();
        $paramDate = $request->get('d');
        $array = [
            '1d' => Carbon::now()->subDays(1),
            '1k' => Carbon::now()->subDays(7),
            '2k' => Carbon::now()->subDays(14),
            '1m' => Carbon::now()->subDays(30),
            '3m' => Carbon::now()->subDays(60),
            '6m' => Carbon::now()->subDays(180),
        ];

        return $array[$paramDate] ?? null;
    }
}
