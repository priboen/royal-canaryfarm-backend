<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChickRequest extends FormRequest
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
            'ring_number' => 'required',
            'photo' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'nullable',
            'canary_type' => 'nullable',
        ];
    }
}
