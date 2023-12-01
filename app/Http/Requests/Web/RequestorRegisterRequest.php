<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class RequestorRegisterRequest extends FormRequest
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
        // birthday should be > 18yrs?
        $age = now()->subYears(18)->format('Y-m-d');

        return [
            'last_name' => ['required'],
            'first_name' => ['required'],
            'suffix' => ['max:10'],
            'sex' => 'required',
            'contact_number' => ['required', 'regex:/^0\d{10}$/', 'unique:students,contact_number'],
            'birth_date' => ['required', 'date', 'before:18 years ago'],
            'birth_place' => ['required', 'min:5'],
            'address' => ['required', 'min:5'],
            'degree' => ['required'],
            // 'major' => ['required'],
            'date_enrolled' => ['required'],
            // 'year_level' => ['required', 'numeric', 'max:5'] // commented
        ];
    }


    public function messages(): array
    {
        return [
            'required' => 'This field is required.',
            'suffix.max' => 'Maximum character is 10.',
            'contact_number.required' => 'This field is required.',
            'contact_number.regex' => 'Please enter valid phone number.',
            'contact_number.unique' => 'This number is already in use.',
            'birth_date.required' => 'This field is required',
            'birth_date.date' => 'Date is not valid.',
            'birth_date.before' => 'Age is below the valid threshold',
            'birth_place.required' => 'This field is required.',
            'birth_place.min' => 'Please enter valid birth place.',
            'address.min' => 'Please enter valid address',
            'year_level.numeric' => 'This field is numeric only.',
            'year_level.max' => 'Maximum year level is 5.'
        ];
    }
}
