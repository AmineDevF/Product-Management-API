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
        $this->authorize('create',Product::class);
        $products = Product::paginate(2);
        // $products = Product::withTrashed()->get();

        return response()->json( $products);
        
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
