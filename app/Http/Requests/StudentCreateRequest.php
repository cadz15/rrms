<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentCreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'student_number' => ['required'],
            'last_name' => ['required'],
            'first_name' => ['required'],
            'suffix' => ['max:10'],
            'sex' => 'required',
            'contact_number' => ['required', 'regex:/^0\d{10}$/', 'unique:users,contact_number'],
            'email' => ['required', 'email'],
            'birth_date' => ['required', 'date', 'before:3 years ago'],
            'birth_place' => ['required', 'min:5'],
            'address' => ['required', 'min:5'],
            'school_name' => ['required'],
            'school_address' => ['required'],
            'degree' => ['required'],
            'date_enrolled' => ['required'],
            'date_graduated' => ['required_if:is_graduated,1']
        ];
    }
}
