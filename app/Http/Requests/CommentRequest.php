<?php

namespace App\Http\Requests;

use App\Dto\CommentFormDto;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'commentable_id' => ['required', 'integer'],
            'commentable_type' => ['required', 'string', 'in:User,Company'],
            'content' => ['required', 'string', 'min:150', 'max:400'],
            'rating' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }

    public function commentFormDto(): CommentFormDto
    {
        return new CommentFormDto(
            $this->input('commentable_id'),
            $this->input('commentable_type'),
            $this->input('content'),
            $this->input('rating')
        );
    }
}
