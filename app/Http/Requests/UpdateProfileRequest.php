<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only authenticated users can update their profile
        return true;
    }

    public function rules(): array
    {
        $userId = auth()->user()->id;

        return [
            'name'  => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,$userId",
            'password' => 'nullable|string|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Name is required.',
            'email.required'    => 'Email is required.',
            'email.email'       => 'Email must be valid.',
            'email.unique'      => 'Email already taken.',
            'password.min'      => 'Password must be at least 6 characters.',
            'password.confirmed'=> 'Password confirmation does not match.',
        ];
    }
}
