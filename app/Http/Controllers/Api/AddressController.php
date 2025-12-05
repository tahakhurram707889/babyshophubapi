<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    // ⭐ Add Address
    public function addAddress(AddressRequest $request)
    {
        $address = Address::create([
            'user_id'      => $request->user()->id,
            'address_line1'=> $request->address_line1,
            'address_line2'=> $request->address_line2,
            'city'         => $request->city,
            'state'        => $request->state,
            'postal_code'  => $request->postal_code,
            'country'      => $request->country,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Address added successfully',
            'address' => $address
        ], 201);
    }

    // ⭐ List User Addresses
    public function myAddresses(Request $request)
    {
        $addresses = Address::where('user_id', $request->user()->id)->get();

        return response()->json([
            'status' => true,
            'addresses' => $addresses
        ]);
    }
}
