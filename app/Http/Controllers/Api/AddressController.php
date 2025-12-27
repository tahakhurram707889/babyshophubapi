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
        // If this is set as default, update other addresses
        if ($request->is_default) {
            Address::where('user_id', $request->user()->id)
                ->update(['is_default' => false]);
        }

      $address = Address::create([
    'user_id'        => $request->user()->id,
    'full_name'      => $request->full_name,
    'phone'          => $request->phone,
    'address_line_1' => $request->address_line_1,
    'address_line_2' => $request->address_line_2,
    'city'           => $request->city,
    'state'          => $request->state,
    'postal_code'    => $request->postal_code,
    'is_default'     => $request->is_default ?? false,
]);


        return response()->json([
            'status'  => true,
            'message' => 'Address added successfully',
            'address' => $address
        ], 201);
    }

    // ⭐ Update Address
    public function updateAddress(AddressRequest $request, $id)
    {
        $address = Address::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$address) {
            return response()->json([
                'status'  => false,
                'message' => 'Address not found'
            ], 404);
        }

        // If this is set as default, update other addresses
        if ($request->is_default) {
            Address::where('user_id', $request->user()->id)
                ->where('id', '!=', $id)
                ->update(['is_default' => false]);
        }

        $address->update([
            'address_line1'=> $request->address_line1,
            'address_line2'=> $request->address_line2,
            'city'         => $request->city,
            'state'        => $request->state,
            'postal_code'  => $request->postal_code,
            // 'country'      => $request->country,
            'is_default'   => $request->is_default ?? $address->is_default,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Address updated successfully',
            'address' => $address
        ]);
    }

    // ⭐ Delete Address
    public function deleteAddress(Request $request, $id)
    {
        $address = Address::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$address) {
            return response()->json([
                'status'  => false,
                'message' => 'Address not found'
            ], 404);
        }

        $address->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Address deleted successfully'
        ]);
    }

    // ⭐ List User Addresses
    public function myAddresses(Request $request)
    {
        $addresses = Address::where('user_id', $request->user()->id)
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'addresses' => $addresses
        ]);
    }

    // ⭐ Get Address by ID
    public function getAddress(Request $request, $id)
    {
        $address = Address::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$address) {
            return response()->json([
                'status'  => false,
                'message' => 'Address not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'address' => $address
        ]);
    }

    // ⭐ Set Default Address
    public function setDefaultAddress(Request $request, $id)
    {
        // First, unset all other default addresses
        Address::where('user_id', $request->user()->id)
            ->update(['is_default' => false]);

        // Set this address as default
        $address = Address::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$address) {
            return response()->json([
                'status'  => false,
                'message' => 'Address not found'
            ], 404);
        }

        $address->update(['is_default' => true]);

        return response()->json([
            'status'  => true,
            'message' => 'Address set as default successfully',
            'address' => $address
        ]);
    }
}