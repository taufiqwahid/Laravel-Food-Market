<?php

namespace App\Http\Requests;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    use PasswordValidationRules;
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
            'name' => ['required', 'string', 'max:225'],
            'email' => ['required', 'string', 'email', 'max:225', 'unique:users'],
            'password' => $this->passwordRules(),
            'address' => ['required', 'string', 'max:225'],
            'roles' => ['required', 'string', 'max:255', 'in:USER,ADMIN'],
            'houseNumber' => ['required', 'string', 'max:225'],
            'phoneNumber' => ['required', 'string', 'max:225'],
            'city' => ['required', 'string', 'max:225'],
        ];
    }
}
