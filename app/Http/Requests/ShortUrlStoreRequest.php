<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShortUrlStoreRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {

        return [
            'long_url' => 'required|url',
            'alias'    => 'nullable|regex:/^[a-zA-Z0-9- ]+$/u|string',
        ];
    }

    public function messages(): array {
        return [
            'alias.regex' => 'Please enter a valid alias, do not use any special character.',
        ];
    }
}
