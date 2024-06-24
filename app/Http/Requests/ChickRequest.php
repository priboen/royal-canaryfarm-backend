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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date_of_birth' => 'required',
            'gender' => 'nullable',
            'canary_type' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'ring_number.required' => 'Ring Number is required',
            'photo.image' => 'Photo must be an image',
            'photo.mimes' => 'Photo must be a file of type: jpeg, png, jpg, gif, svg',
            'photo.max' => 'Photo may not be greater than 2048 kilobytes',
            'date_of_birth.required' => 'Date of Birth is required',
        ];
    }
}
