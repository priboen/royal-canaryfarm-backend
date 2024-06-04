<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|min:5',
            'username' => 'required|string|unique:users|min:5|regex:/^[a-zA-Z0-9_]+$/|unique:users|min:5',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ];
    }
}