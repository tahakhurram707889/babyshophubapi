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
        // For update, product_id might not be required
        $rules = [
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|max:500',
        ];

        // Only require product_id for store, not for update
        if ($this->isMethod('post')) {
            $rules['product_id'] = 'required|exists:products,id';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Please select a product.',
            'product_id.exists'   => 'The selected product does not exist.',
            'rating.required'     => 'Rating is required.',
            'rating.integer'      => 'Rating must be a whole number.',
            'rating.min'          => 'Rating must be at least 1 star.',
            'rating.max'          => 'Rating cannot be more than 5 stars.',
            'review.required'     => 'Review text is required.',
            'review.string'       => 'Review must be text.',
            'review.max'          => 'Review cannot exceed 500 characters.',
        ];
    }
}