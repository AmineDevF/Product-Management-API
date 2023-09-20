<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RouleController extends Controller
{
    public function dashboard()
    {
        $this->authorize('admin', Product::class);
        $user = User::all();
        $user_permissions  = User::with('permissions')->get();
       
     return response()->json($user_permissions );

    }
    public function update(Request $request, $id)
    {
        $this->authorize('admin', Product::class);
        $userPermission  = UserPermission::find($id);
        $validatedData = $request->validate([
            'user_id' => 'required',
            'permission_id' => 'required',
        ]);

        $userPermission->update([
            'user_id' =>  $validatedData['user_id'],
            'permission_id' =>  $validatedData['permission_id'],
        ]);
        return   $userPermission;
    }
    public function createProfeil(Request $request)
    {
       
        $this->authorize('admin', Product::class);
        $validatedData = $request->validate([
            'user_id' => 'required',
            'permission_id' => 'required',
        ]);

        $userPermission = UserPermission::create([
            'user_id' =>  $validatedData['user_id'],
            'permission_id' =>  $validatedData['permission_id'],
        ]);
        

        return response()->json([
            'access_token' =>  $userPermission,
            'statu' => '200',
     ]);
    }
}
