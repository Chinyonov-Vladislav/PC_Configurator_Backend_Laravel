<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CodeRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'code'=>"required|string|regex:/^[0-9]+$/|size:6"
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        $response = [];
        // Перечислите поля, которые должны иметь пустой массив ошибок, если они прошли валидацию
        $fieldsToCheck = ['email', 'code'];
        foreach ($fieldsToCheck as $field) {
            $response['errors'][$field] = $errors[$field] ?? [];
        }
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
    public function messages()
    {
        return [
            'email.required' => __('messages.error_required_field', ['name' => __("messages.email")]),
            'email.email' => __('messages.error_email_field', ['name' => __("messages.email")]),
            'email.exists'=> __("messages.error_exist_user_by_email", ['email'=>$this->input("email")]),
            "code.required"=>__('messages.error_required_field', ['name' => __("messages.code")]),
            "code.string"=>__("messages.error_type_field", ["name"=>__("messages.code"),"type"=>__("messages.string")]),
            "code.reqex"=>__("messages.only_digits", ["name" => __("messages.code")]),
            "code:size"=>__("messages.size_only_digits_field", ["name" => __("messages.code"), "count" =>"6"])
        ];
    }
}
