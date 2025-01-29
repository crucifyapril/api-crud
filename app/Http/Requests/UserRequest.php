<?php

namespace App\Http\Requests;

use App\Dto\UserFormDto;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id');

        return [
            'first_name' => ['required', 'string', 'min:3', 'max:40'],
            'last_name' => ['required', 'string', 'min:3', 'max:40'],
            'phone' => ['required', 'string', 'regex:/^\+7\d{10}$/', 'unique:users,phone,' . $userId],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }

    public function userFormDto(): UserFormDto
    {
        return new UserFormDto(
            $this->input('first_name'),
            $this->input('last_name'),
            $this->input('phone'),
            $this->input('avatar')
        );
    }
}
