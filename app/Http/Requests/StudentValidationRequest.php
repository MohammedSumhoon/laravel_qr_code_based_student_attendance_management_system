<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StudentValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        if (request()->routeIs('store_student_details')) {
            return [
                'student_name' => 'required|max:25',
                'student_email' => 'required|email|unique:students,student_email',
                'student_contactno' => 'required|min:10|max:10'
            ];
        } else if (request()->routeIs('leave_sheet')) {
            return [
                'name' => 'required|string|min:3|max:20',
                'regno' => 'required|string|min:8',
                'reason' => 'required|min:5'
            ];
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => true
        ], 422));
    }
}
