<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'max:2048',
                'mimes:jpg,jpeg,png',
            ],
            'collection' => [
                'nullable',
                'string',
                'max:255',
            ],
        ];
    }
}
