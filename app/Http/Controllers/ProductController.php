<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->authorize('create',Product::class);
        // $products = Product::paginate(4);
        // // $products = Product::withTrashed()->get();

        // // return response()->json( $products);
        // return view('products.index',compact('products'));

        $jsonData = '{
            "data": [
                {
                    "id": 18,
                    "title": "Recusandae dolores at voluptatum accusamus et. Ullam et vel sed ipsum. Ad repudiandae veniam id molestias dolorum.",
                    "image_url": null,
                    "price": "2.84",
                    "quantity": null,
                    "updated_at": "2024-02-13 23:35:13"
                },
                {
                    "id": 19,
                    "title": "Quia unde iure rem tempore ut dolorem impedit. Molestias aspernatur esse consectetur voluptates sed nemo voluptas. Et dolorum atque laudantium magnam. Voluptas ullam qui repudiandae officiis debitis.",
                    "image_url": null,
                    "price": "2.66",
                    "quantity": null,
                    "updated_at": "2024-02-13 23:35:13"
                },
                {
                    "id": 20,
                    "title": "Quasi sit deserunt eos adipisci id est in voluptas. Magni necessitatibus molestiae eum id. Quam cumque ut qui ratione eum accusantium tempora. Quibusdam nesciunt unde error asperiores aut sit.",
                    "image_url": null,
                    "price": "3.68",
                    "quantity": null,
                    "updated_at": "2024-02-13 23:35:13"
                },
                {
                    "id": 21,
                    "title": "Velit culpa id reprehenderit labore quibusdam. Laboriosam quis ut velit occaecati molestiae. Laudantium eum inventore natus hic ut expedita ea ducimus.",
                    "image_url": null,
                    "price": "2.68",
                    "quantity": null,
                    "updated_at": "2024-02-13 23:35:13"
                },
                {
                    "id": 22,
                    "title": "Non et est facilis ut necessitatibus pariatur. Et veritatis quia quo facilis quia. Nulla sed itaque laboriosam inventore itaque.",
                    "image_url": null,
                    "price": "4.75",
                    "quantity": null,
                    "updated_at": "2024-02-13 23:35:13"
                },
                {
                    "id": 23,
                    "title": "Itaque atque asperiores dolores possimus commodi. Illo tempore molestias ea. Cum quidem dolor dicta voluptatem.",
                    "image_url": null,
                    "price": "2.56",
                    "quantity": null,
                    "updated_at": "2024-02-13 23:35:13"
                },
                {
                    "id": 24,
                    "title": "Qui aut molestiae voluptatibus et. Sint nostrum voluptatem dolor sit laborum excepturi aperiam. Cum qui inventore dolorem libero accusantium.",
                    "image_url": null,
                    "price": "2.17",
                    "quantity": null,
                    "updated_at": "2024-02-13 23:35:13"
                },
                {
                    "id": 25,
                    "title": "Est distinctio blanditiis tempora est accusamus. Sed est veritatis sint facilis.",
                    "image_url": null,
                    "price": "3.10",
                    "quantity": null,
                    "updated_at": "2024-02-13 23:35:13"
                },
                {
                    "id": 26,
                    "title": "Velit est omnis quis magnam nihil voluptatem. Iure accusamus rerum repellendus. Impedit omnis molestiae modi voluptatem quae beatae.",
                    "image_url": null,
                    "price": "4.12",
                    "quantity": null,
                    "updated_at": "2024-02-13 23:35:13"
                },
                {
                    "id": 46,
                    "title": "Aut sint esse modi voluptas temporibus id. Natus a aut aliquam est ea et. Sed voluptas assumenda enim eos et cum.",
                    "image_url": null,
                    "price": "2.66",
                    "quantity": null,
                    "updated_at": "2024-02-13 23:35:13"
                }
            ],
            "links": {
                "first": "http://127.0.0.1:8000/api/products?page=1",
                "last": "http://127.0.0.1:8000/api/products?page=4",
                "prev": null,
                "next": "http://127.0.0.1:8000/api/products?page=2"
            },
            "meta": {
                "current_page": 1,
                "from": 1,
                "last_page": 4,
                "links": [
                    {
                        "url": null,
                        "label": "&laquo; Previous",
                        "active": false
                    },
                    {
                        "url": "http://127.0.0.1:8000/api/products?page=1",
                        "label": "1",
                        "active": true
                    },
                    {
                        "url": "http://127.0.0.1:8000/api/products?page=2",
                        "label": "2",
                        "active": false
                    },
                    {
                        "url": "http://127.0.0.1:8000/api/products?page=3",
                        "label": "3",
                        "active": false
                    },
                    {
                        "url": "http://127.0.0.1:8000/api/products?page=4",
                        "label": "4",
                        "active": false
                    },
                    {
                        "url": "http://127.0.0.1:8000/api/products?page=2",
                        "label": "Next &raquo;",
                        "active": false
                    }
                ],
                "path": "http://127.0.0.1:8000/api/products",
                "per_page": 10,
                "to": 10,
                "total": 40
            }
        }';
        
        // Convert JSON string to PHP array
        $data = json_decode($jsonData, true);
        
      
        
                
                return response()->json($data);
        
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('products.create');
    }
  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'name' => 'required',
            'detail' => 'required',
            'prix' => 'required',
            'quantite' => 'required',
        ]);
        $image_path = $request->file('image')->store('image', 'public');
 
        $data = Product::create([  
            'image' => $image_path,
            'name' => $request->name,
            'prix' => $request->prix,  
            'detail' => $request->detail,
            'quantite' => $request->quantite,
            
        ]);

        return response()->json($data);
    }


  
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): View
    {
        return view('products.edit',compact('product'));
    }
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product) 
    {
       
        $request->validate([

            // 'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'name' => 'required',
            'detail' => 'required',
            'prix' => 'required',
            'quantite' => 'required',
        ]);
        

        $input = $request->all();


        if ($image = $request->file('image')) {

            $destinationPath = 'image/';

            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();

            $image->move($destinationPath, $profileImage);

            $input['image'] = "$profileImage";

        }else{

            unset($input['image']);

        }
          
        $product->update($input); 


        return response()->json($product);

 }
  
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        
        $product->delete();
         
        return response()->json(["product was deleted successfully",$product]);
    }

    public function forceDelete($id)
    {
        $product = Product::find($id);
       
        
        $product->forcedelete();
         
        return response()->json($product);
    }
    public function onlyTrachedProduct()
    {
        $product = Product::onlyTrashed()->get();
       
         
        return response()->json($product);
    }
}
