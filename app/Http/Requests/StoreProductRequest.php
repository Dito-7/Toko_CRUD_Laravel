<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'sku' => ['required', 'unique:products', 'max:100'],
            'name' => ['required', 'max:100'],
            'price' => ['required', 'numeric', 'min:1'],
            'stock' => ['required', 'numeric', 'min:0'],
            'description' => ['required'],
            'fotoProduct' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:2048',
            'brand_id' => ['required'],
            'category_ids' => ['required', 'array', 'min:1']
        ];
    }
}