<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this r   quest.
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
            //
            'content' => 'required',
            'title' => 'required',
            'type' => 'required',
            'tags' => 'required',
            'published' => 'required',
            // 'category' => 'required',
            'description' => 'required|min:6|max:200',
            'featuredImage' => 'required|file|max:5120',
            'category' => 'exclude_if:type!=3,true|required'
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Please Fill Content',
            'title.required' => 'Please Fill  Title',
            'type.required' => 'Please Choose Type',
            'tags.required' => 'Please select tags',
            'description.required' => 'Please add description',
            'featuredImage.required' => 'Please Upload featured Image',
        ];
    }
}
