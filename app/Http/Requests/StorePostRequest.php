<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'min:3'],
            'slug' => ['required', 'string', 'max:255', 'min:3', 'unique:posts'],
            'short_text' => ['required', 'string'],
            'large_text' => ['required', 'string'],
            'category_id' => ['required'],
        ];
    }
}
