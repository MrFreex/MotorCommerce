<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; 
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SettingsRequest extends FormRequest
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
            'email' => ['required', 'email:rfc,dns', Rule::unique('users')->ignore(Auth::user()->id) ],
            'username' => ['required', 'alpha_dash', Rule::unique('users')->ignore(Auth::user()->id), 'min:3' ],
            'displayname' => ['required', 'alpha_dash', Rule::unique('users')->ignore(Auth::user()->id), 'different:username', 'min:3' ],
            'phone' => 'numeric|nullable',
            'birthday' => 'date|required',
            'zip' => 'numeric|nullable',
        ];
    }
}
