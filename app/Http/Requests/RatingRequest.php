<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RatingRequest extends FormRequest
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
    protected function prepareForValidation()
    {
        $this->merge([
            'rating' => filter_var($this->rating, FILTER_VALIDATE_BOOLEAN)
        ]);
    }
    public function rules(): array
    {
        return [
            'typeComputerPart' => 'required|int|exists:computer_parts,id',
            "idComputerPart"=>"required|int",
            'rating'=>"required|boolean",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->toArray();
        $response = [];
        $fieldsToCheck = ['typeComputerPart',"idComputerPart", 'rating'];
        foreach ($fieldsToCheck as $field) {
            $response['errors'][$field] = $errors[$field] ?? [];
        }
        throw new HttpResponseException(response()->json($response, 422));
    }
    public function messages(): array
    {
        return [
            'typeComputerPart.required' => __('messages.error_required_field', ['name' => __("messages.type_computer_part")]),
            'typeComputerPart.int' => __('messages.error_type_field', ['name' => __("messages.type_computer_part"), "type"=>__("messages.integer")]),
            'typeComputerPart.exists' => __('messages.error_exist_value', ['name' => __("messages.type_computer_part")]),
            'idComputerPart.required' => __('messages.error_required_field', ['name' => __("messages.id_computer_part")]),
            'idComputerPart.int' => __('messages.error_type_field', ['name' => __("messages.id_computer_part"), "type"=>__("messages.integer")]),
            'rating.required' => __('messages.error_required_field', ['name' => __("messages.rating")]),
            'rating.boolean' => __('messages.error_type_field', ['name' => __("messages.rating"), "type"=>__("messages.bool")]),
        ];
    }
}
