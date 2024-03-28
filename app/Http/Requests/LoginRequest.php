<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        $response = [];
        // Перечислите поля, которые должны иметь пустой массив ошибок, если они прошли валидацию
        $fieldsToCheck = ['email', 'password'];
        foreach ($fieldsToCheck as $field) {
            $response['errors'][$field] = $errors[$field] ?? [];
        }
        throw new HttpResponseException(response()->json($response, 422));
        //throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
    public function messages()
    {
        return [
            'email.required' => __('messages.error_required_field', ['name' => __("messages.email")]),
            'email.email' => __('messages.error_email_field', ['name' => __("messages.email")]),
            'email.exists' => __('messages.error_exist_user_by_email', ['email' => $this->input("email")]),
            'password.required' => __('messages.error_required_field', ['name' => __("messages.password")]),
            'password.string' => __("messages.error_type_field",["name"=>__("messages.password"), "type"=>__("messages.string")]),
            'password.min' => __("messages.error_min_field", ["name"=>__("messages.password"), "count"=>"8"]),
        ];
    }
}
