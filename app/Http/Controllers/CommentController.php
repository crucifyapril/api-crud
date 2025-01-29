<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Services\CommentService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends Controller
{
    public function __construct(
        private readonly CommentService $commentService
    ) {
    }

    public function create(CommentRequest $request): JsonResponse
    {
        try {
            $this->commentService->createComment($request->commentFormDto());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(['success' => true], Response::HTTP_CREATED);
    }

    public function update(int $id, CommentRequest $request): JsonResponse
    {
        try {
            $this->commentService->updateComment($id, $request->commentFormDto());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['success' => true]);
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->commentService->deleteComment($id);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['success' => true]);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $comment = $this->commentService->getComment($id);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return response()->json($comment);
    }

    public function getCommentsByCompany(int $companyId): JsonResponse
    {
        try {
            $comments = $this->commentService->getCommentsByCompanyId($companyId);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return response()->json($comments);
    }
}
