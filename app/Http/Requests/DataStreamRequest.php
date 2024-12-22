<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DataStreamRequest extends FormRequest
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
            'stream' => 'required|string',
            'k' => 'required|integer|min:1',
            'top' => 'required|integer|min:1',
            'exclude' => 'array',
            'exclude.*' => 'string',
        ];
    }
}
