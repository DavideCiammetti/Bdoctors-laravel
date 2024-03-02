<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDoctorsRequest extends FormRequest
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
            'slug'=> ['nullable'],
            'doctor_img'=> ['nullable','image', 'max:4096'],
            'user_id'=> ['nullable', 'exists:users,id'],
            'specializations'=> [ 'required', 'exists:specializations,id'],
            'doctor_cv' => ['nullable', 'mimes:pdf'],
            'is_available' => ['nullable'],
            'services' => ['nullable'],
            'address' => ['max:100', 'required'],
            'name' => ['max:30', 'required'],
            'surname' => ['max:40', 'required'],
            'phone_number' => ['max:100', 'nullable','string'],
        ];
    }
}
