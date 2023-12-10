<?php

namespace App\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
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
            'degree' => ['required', 'exists:majors,id'],
            'date_enrolled' => ['required', 'date_format:Y-m-d'],
            'year_level' => ['required', 'numeric', 'min: 1'],
            'is_graduated' => ['string', 'in:0,1'],
            'year_end' => ['nullable', 'date_format:Y-m-d'],
            'school_name' => ['required', 'string'],
            'school_address' => ['required', 'string'],
        ];
    }
}
