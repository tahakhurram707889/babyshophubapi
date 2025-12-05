<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only authenticated users can add addresses
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city'          => 'required|string|max:100',
            'state'         => 'required|string|max:100',
            'postal_code'   => 'required|string|max:20',
            'country'       => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'address_line1.required' => 'Address Line 1 is required.',
            'city.required'          => 'City is required.',
            'state.required'         => 'State is required.',
            'postal_code.required'   => 'Postal code is required.',
            'country.required'       => 'Country is required.',
        ];
    }
}
