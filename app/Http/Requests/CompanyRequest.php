<?php

namespace App\Http\Requests;

use App\Dto\CompanyFormDto;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:40'],
            'description' => ['required', 'string', 'min:150', 'max:400'],
            'logo' => ['nullable', 'image', 'mimes:png', 'max:3072'],
        ];
    }

    public function companyFormDto(): CompanyFormDto
    {
        return new CompanyFormDto(
            $this->input('name'),
            $this->input('description'),
            $this->input('logo')
        );
    }
}
