<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only authenticated users can submit reviews
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'rating'     => 'required|numeric|min:1|max:5',
            'review'     => 'required|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Please select a product.',
            'product_id.exists'   => 'The selected product does not exist.',
            'rating.required'     => 'Rating is required.',
            'rating.numeric'      => 'Rating must be a number.',
            'rating.min'          => 'Rating must be at least 1.',
            'rating.max'          => 'Rating cannot be more than 5.',
            'review.required'     => 'Review text is required.',
            'review.max'          => 'Review cannot exceed 500 characters.',
        ];
    }
}
