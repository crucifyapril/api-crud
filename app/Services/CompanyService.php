<?php

namespace App\Services;

use App\Dto\CompanyFormDto;
use App\Models\Comment;
use App\Models\Company;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class CompanyService
{
    public function createCompany(CompanyFormDto $dto)
    {
        return Company::query()->create([
            'name' => $dto->name,
            'description' => $dto->description,
            'logo' => $dto->logo
        ]);
    }


    public function updateCompany(int $companyId, CompanyFormDto $dto)
    {
        $user = Company::query()->findOrFail($companyId);

        $user->update([
            'name' => $dto->name,
            'description' => $dto->description,
            'logo' => $dto->logo
        ]);

        return $user;
    }

    public function deleteCompany(int $companyId): bool
    {
        $user = Company::query()->findOrFail($companyId);

        return $user->delete();
    }

    public function getCompany(int $companyId)
    {
        return Company::query()->findOrFail($companyId);
    }

    /**
     * @throws Exception
     */
    public function getCompanyRating(int $companyId): float
    {
        $company = Company::query()->findOrFail($companyId);

        if (!$company) {
            throw new Exception("Компания не найдена", 404);
        }

        $comments = Comment::query()->where('commentable_id', $companyId)
            ->where('commentable_type', 'Company')
            ->avg('rating');

        if (!$comments) {
            return 0;
        }

        return round($comments, 1);
    }

    public function getTopCompaniesByRating(): Collection
    {
        $companies = Company::all();

        $companiesWithRatings = $companies->map(function ($company) {
            $averageRating = Comment::query()->where('commentable_id', $company->id)
                ->where('commentable_type', 'Company')
                ->avg('rating');

            $company->rating = $averageRating ? round($averageRating, 1) : 0;

            return $company;
        });

        $companiesWithRatings = $companiesWithRatings->sortByDesc('rating');

        return $companiesWithRatings->take(10);
    }
}
