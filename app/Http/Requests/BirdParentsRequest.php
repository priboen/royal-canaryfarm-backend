<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BirdParentsRequest extends FormRequest
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
            'breeder_id' => 'required|exists:users,id',
            'ring_number' => 'required',
            'photo' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required',
            'canary_type' => 'required',
            'type_description' => 'required'
        ];
    }
}
