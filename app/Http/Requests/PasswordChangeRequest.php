<?php

namespace App\Http\Requests;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class PasswordChangeRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'current_password' => ['required', new MatchOldPassword],
            'password' => 'required|min:6|max:20|confirmed',
            'password_confirmation' => 'required|min:6|max:20|same:password'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Please Fill Name',
            'current_password.required' => 'Please Fill Your Current Password',
            'password.required' => 'Please Fill Your New Password',
            'password_confirmation.required' => 'Please Fill Confirmation',
        ];
    }
}
