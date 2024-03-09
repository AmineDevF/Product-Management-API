<?php

namespace App\Http\Controllers;

use App\Enums\CustomerStatus;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = User::query()
        ->where('role','user')
        ->orderBy($sortField, $sortDirection);

        if ($search) {
            $query
                ->where('name', 'like', "%{$search}%")
                ->orWhere('users.email', 'like', "%{$search}%")
                ->orWhere('users.phone', 'like', "%{$search}%");
        }

        $paginator = $query->paginate($perPage);


        // $query = User::query()
        //     ->where('role','user')
        //     ->orderBy($sortField, $sortDirection)
        //     ->paginate($perPage);
          
        return CustomerResource::collection($paginator);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $customer )
    {
     
        return new CustomerResource($customer );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User     $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, User $customer)
    {
        
        $customerData = $request->validated();
        $customerData['updeted_by'] = auth()->id();
        $customerData['status'] = $customerData['status'] ? CustomerStatus::Active->value : CustomerStatus::Disabled->value;
        DB::beginTransaction();
        
            $customer->update($customerData);


        DB::commit();

        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $customer)
    {
        $customer->delete();

        return response()->noContent();
    }

   

}
