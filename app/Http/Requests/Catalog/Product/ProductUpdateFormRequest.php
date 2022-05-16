<?php

declare(strict_types=1);

namespace App\Http\Requests\Catalog\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductUpdateFormRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'brand' => ['nullable', 'integer'],
            'reference' => ['required', 'string', Rule::unique('products')->ignore($this->route('product'), 'uuid')],
            'price' => ['nullable', 'numeric'],
            'quantity'=>['required', 'numeric'],
            'category' => ['nullable', 'integer'],

            'colors' => ['nullable', 'array'],
            'colors.*' => ['nullable', 'integer'],

            'description' => ['nullable', 'string'],

            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:1024'],
        ];
    }
}
