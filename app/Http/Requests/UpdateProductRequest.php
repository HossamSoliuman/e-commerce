<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['string', 'max:255', 'nullable'],
            'description' => ['string', 'nullable'],
            'price' => ['integer', 'nullable'],
            'cover' => ['file', 'image', 'mimes:jpeg,png,jpg,gif', 'nullable'],
            'category_id' => ['integer', 'exists:categories,id', 'nullable'],
            'offer_content' => ['string', 'nullable'],
            'offer_enabled' => ['boolean', 'nullable'],
        ];
    }
}
