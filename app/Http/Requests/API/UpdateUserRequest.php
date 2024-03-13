<?php

namespace App\Http\Requests\API;

use App\Rules\IsValidRole;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
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
            'email' => 'required|email|unique:users,id' . $this->id,
            'password' => 'required|confirmed',
            'roles' => ['required', 'array', new IsValidRole]
        ];
    }
}
