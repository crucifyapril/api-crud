<?php

namespace App\Services;

use App\Dto\UserFormDto;
use App\Models\User;

class UserService
{
    public function createUser(UserFormDto $dto): User
    {
        return User::query()->create([
            'first_name' => $dto->first_name,
            'last_name' => $dto->last_name,
            'phone' => $dto->phone,
            'avatar' => $dto->avatar
        ]);
    }


    public function updateUser(int $userId, UserFormDto $dto): User
    {
        $user = User::query()->findOrFail($userId);

        $user->update([
            'first_name' => $dto->first_name,
            'last_name' => $dto->last_name,
            'phone' => $dto->phone,
            'avatar' => $dto->avatar
        ]);

        return $user;
    }

    public function deleteUser(int $userId): bool
    {
        $user = User::query()->findOrFail($userId);

        return $user->delete();
    }

    public function getUser(int $userId): User
    {
        return User::query()->findOrFail($userId);
    }
}
