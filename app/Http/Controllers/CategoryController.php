<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function countries()
    {
        return [
            'code' => "fe23",
            'name' => "fes",
            'states' => 'VD',
        ];
        
    }
    public function index()
    {
        // $sortField = request('sort_field', 'updated_at');
        // $sortDirection = request('sort_direction', 'desc');

        // $categories = Category::query()
        //     ->orderBy($sortField, $sortDirection)
        //     ->latest()
        //     ->get();

        // return $categories;
        $jsonData = '{
            "data": [
                {
                    "id": 3,
                    "name": "Telephone",
                    "slug": "telephone",
                    "active": 1,
                    "parent_id": 1,
                    "parent": {
                        "id": 1,
                        "name": "accessoire",
                        "slug": "accessoire",
                        "active": 1,
                        "parent_id": null,
                        "parent": null,
                        "created_at": "2023-11-05 15:04:43",
                        "updated_at": "2023-11-05 15:04:43"
                    },
                    "created_at": "2023-11-15 09:29:20",
                    "updated_at": "2024-02-13 13:07:16"
                },
                {
                    "id": 5,
                    "name": "airpods",
                    "slug": "airpods",
                    "active": 0,
                    "parent_id": 3,
                    "parent": {
                        "id": 3,
                        "name": "Telephone",
                        "slug": "telephone",
                        "active": 1,
                        "parent_id": 1,
                        "parent": {
                            "id": 1,
                            "name": "accessoire",
                            "slug": "accessoire",
                            "active": 1,
                            "parent_id": null,
                            "parent": null,
                            "created_at": "2023-11-05 15:04:43",
                            "updated_at": "2023-11-05 15:04:43"
                        },
                        "created_at": "2023-11-15 09:29:20",
                        "updated_at": "2024-02-13 13:07:16"
                    },
                    "created_at": "2024-02-12 22:08:56",
                    "updated_at": "2024-02-13 13:06:57"
                },
                {
                    "id": 2,
                    "name": "TV",
                    "slug": "tv",
                    "active": 1,
                    "parent_id": 1,
                    "parent": {
                        "id": 1,
                        "name": "accessoire",
                        "slug": "accessoire",
                        "active": 1,
                        "parent_id": null,
                        "parent": null,
                        "created_at": "2023-11-05 15:04:43",
                        "updated_at": "2023-11-05 15:04:43"
                    },
                    "created_at": "2023-11-14 10:43:27",
                    "updated_at": "2023-11-14 10:43:27"
                },
                {
                    "id": 1,
                    "name": "accessoire",
                    "slug": "accessoire",
                    "active": 1,
                    "parent_id": null,
                    "parent": null,
                    "created_at": "2023-11-05 15:04:43",
                    "updated_at": "2023-11-05 15:04:43"
                }
            ]
        }';
        
        // Convert JSON string to PHP array
        $data = json_decode($jsonData, true);
        return response()->json($data);
    }

    public function getAsTree()
    {
        return Category::all();
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
            'slug' => 'required',
        ]);
        $image_path = $request->file('image')->store('image', 'public');
 
        $data = Category::create([  
            'image' => $image_path,
            'slug' => $request->slug,
            'name' => $request->name,  
            
        ]);

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([

           
            'name' => 'required',
            'slug' => 'required',
             // 'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
           
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
          
        $category->update($input); 


        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();
    }
}
