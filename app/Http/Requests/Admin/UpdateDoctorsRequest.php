<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Admin\Specialization;

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
            'slug' => ['nullable'],
            'doctor_img' => ['nullable', 'image', 'max:4096'],
            'user_id' => ['nullable', 'exists:users,id'],
            'specializations' => 'required|exists:specializations,id',
            // 'specializations'=> ['required','exists:specializations,id',Rule::in($this->SpecializationsId())],
            'doctor_cv' => ['nullable', 'mimes:pdf,svg,png,jpg,jpeg,webp', 'max:4096'],
            'is_available' => ['nullable', Rule::in('0', '1')],
            'services' => ['nullable'],
            'address' => ['max:100', 'required'],
            'name' => ['max:30', 'required', 'regex:/^[a-zA-Z\-\,\.\s]+$/'],
            'surname' => ['max:40', 'required', 'regex:/^[a-zA-Z\-\,\.\s]+$/'],
            'phone_number' => ['max:15', 'nullable', 'string', 'regex:/^[\d\+\/\- ]+$/'],
        ];
    }

    public function messages()
    {
        return [
            'phone_number.regex' => 'The phone number field can only contain numbers, or symbols such as \'+\', \'/\', or \'-\' as a prefix or separator.',
            'specializations.required' => 'At least one specialization is required.',
        ];
    }

    public function SpecializationsId()
    {
        $specializations = Specialization::all();
        return $specializationIds = Specialization::pluck('id')->toArray();
    }
}
