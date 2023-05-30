<?php

namespace App\Services\Contracts;

use App\Models\User;

interface IUserBankingService
{
    /**
     * Get user total balance in all banks
     * @param User $user
     * @return int
     */
    public function getTotalBalance(User $user): int;
}
