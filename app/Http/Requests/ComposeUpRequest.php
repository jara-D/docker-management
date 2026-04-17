<?php

namespace App\Http\Requests;

use App\Rules\ValidComposeYaml;
use Auth;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\Yaml\Yaml;

class ComposeUpRequest extends FormRequest
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
        if (is_string($this->yaml)) {
            $this->merge([
                'yaml' => str_replace('\n', "\n", $this->yaml),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'projectName' => 'required|string',
            'yaml' => ['required', 'string', new ValidComposeYaml],
            'file' => 'nullable|file',
        ];
    }
}
