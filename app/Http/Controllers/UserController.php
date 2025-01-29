<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function create(UserRequest $request): JsonResponse
    {
        try {
            $this->userService->createUser($request->userFormDto());
        } catch (Exception) {
            return response()->json(['success' => false], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(['success' => true]);
    }

    public function update(int $id, UserRequest $request): JsonResponse
    {
        try {
            $this->userService->updateUser($id, $request->userFormDto());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['success' => true]);
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->userService->deleteUser($id);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['success' => true]);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->userService->getUser($id);
            return response()->json($user);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
