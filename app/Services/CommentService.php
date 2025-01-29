<?php

namespace App\Services;

use App\Dto\CommentFormDto;
use App\Models\Comment;
use App\Models\Company;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class CommentService
{
    public function createComment(CommentFormDto $dto): Comment
    {
        return Comment::query()->create([
            'commentable_id' => $dto->commentable_id,
            'commentable_type' => $dto->commentable_type,
            'content' => $dto->content,
            'rating' => $dto->rating,
        ]);
    }

    public function updateComment(int $id, CommentFormDto $dto): Comment
    {
        $comment = Comment::query()->findOrFail($id);
        $comment->update([
            'commentable_id' => $dto->commentable_id,
            'commentable_type' => $dto->commentable_type,
            'content' => $dto->content,
            'rating' => $dto->rating,
        ]);

        return $comment;
    }

    public function deleteComment(int $id): bool
    {
        $comment = Comment::query()->findOrFail($id);
        return $comment->delete();
    }

    public function getComment(int $id): Comment
    {
        return Comment::query()->findOrFail($id);
    }

    public function getCommentsByCompanyId(int $companyId): Collection
    {
        return Comment::query()->where('commentable_type', 'Company')
        ->where('commentable_id', $companyId)
        ->get();
    }
}
