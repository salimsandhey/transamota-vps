<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only authenticated users can create products
        return auth()->check() && auth()->user()->role === 'seller';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'description' => 'required|string',
            'price' => 'nullable|numeric|min:0',
            'moq' => 'required|integer|min:1',
            'unit' => 'required|string|max:50',
            'origin_country' => 'required|string|max:100',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }
    
    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required',
            'category_id.required' => 'Category is required',
            'description.required' => 'Description is required',
            'moq.required' => 'Minimum Order Quantity is required',
            'unit.required' => 'Unit is required',
            'origin_country.required' => 'Origin country is required',
            'images.*.image' => 'Each file must be an image',
            'images.*.mimes' => 'Image must be a file of type: jpeg, png, jpg, gif, webp',
            'images.*.max' => 'Each image must not be greater than 2MB',
        ];
    }
}