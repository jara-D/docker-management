<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComposeUpReqeust extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $yaml = $this->yaml;

        $yaml = str_replace('\n', "\n", $yaml);

        $this->merge([
            'yaml' => $yaml,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'projectName' => 'required|string',
            'yaml' => 'required|string',
        ];
    }
}
