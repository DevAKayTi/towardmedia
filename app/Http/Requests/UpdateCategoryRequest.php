<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateCategoryRequest extends FormRequest
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
        $id = $this->route('category');

        return [
            //
            'name' => 'required|max:20|min:3|unique:categories,name,' . $id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Please Fill Name',
        ];
    }
}
