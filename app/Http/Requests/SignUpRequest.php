<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SignUpRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();

        $response = [];

        // Перечислите поля, которые должны иметь пустой массив ошибок, если они прошли валидацию
        $fieldsToCheck = ['name', 'email', 'password'];

        foreach ($fieldsToCheck as $field) {
            $response['errors'][$field] = $errors[$field] ?? [];
        }

        throw new HttpResponseException(response()->json($response, 422));
        //throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
    public function messages()
    {
        return [
            'name.required' => __('messages.error_required_field', ['name' => __("messages.name_user")]),
            'name.string' => __("error_type_field",["name"=>__("messages.name_user"), "type"=>__("messages.string")]),
            'email.required' => __('messages.error_required_field', ['name' => __("messages.email")]),
            'email.email' => __('messages.error_email_field', ['name' => __("messages.email")]),
            'email.unique' => __('messages.error_unique_field', ['name' => __("messages.email")]),
            'password.required' => __('messages.error_required_field', ['name' => __("messages.password")]),
            'password.string' => __("messages.error_type_field",["name"=>__("messages.password"), "type"=>__("messages.string")]),
            'password.confirmed' => __("messages.error_confirmation_field",
                ["name_first"=>__("messages.password"), "name_second"=>__("messages.")]),
            'password.min' => __("messages.error_min_field", ["name"=>__("messages.password"), "count"=>"8"]),
        ];
    }
}
