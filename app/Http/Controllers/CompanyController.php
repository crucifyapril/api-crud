<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Services\CompanyService;
use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    public function __construct(
        private readonly CompanyService $companyService
    ) {
    }

    public function create(CompanyRequest $request): JsonResponse
    {
        try {
            $this->companyService->createCompany($request->companyFormDto());
        } catch (Exception) {
            return response()->json(['success' => false], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(['success' => true]);
    }

    public function update(int $id, CompanyRequest $request): JsonResponse
    {
        try {
            $this->companyService->updateCompany($id, $request->companyFormDto());
        } catch (Exception) {
            return response()->json(['error' => 'Company not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['success' => true]);
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->companyService->deleteCompany($id);
        } catch (Exception) {
            return response()->json(['error' => 'Company not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['success' => true]);
    }

    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->companyService->getCompany($id);
            return response()->json($user);
        } catch (Exception) {
            return response()->json(['error' => 'Company not found'], Response::HTTP_NOT_FOUND);
        }
    }

    public function getCompanyRating(int $companyId): JsonResponse
    {
        try {
            $rating = $this->companyService->getCompanyRating($companyId);
        } catch (Exception) {
            return response()->json(['error' => 'Company not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['rating' => $rating]);
    }

    public function getTopCompanies(): JsonResponse
    {
        try {
            $rating = $this->companyService->getTopCompaniesByRating();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        return response()->json($rating);
    }
}
