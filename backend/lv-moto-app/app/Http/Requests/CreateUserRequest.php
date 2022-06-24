<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateUserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'username' => 'required|alpha_dash|unique:users,username',
            'password' => 'required|alpha_dash|min:8',
            'displayname' => 'required|unique:users|different:username|min:3',
            'birthday' => 'required|date|before:-16 years',
            'zip' => 'numeric|nullable',
            'phone' => 'numeric|nullable',
        ];
    }
}
