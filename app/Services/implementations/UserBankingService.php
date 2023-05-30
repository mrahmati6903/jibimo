<?php

namespace App\Services\implementations;

use App\Models\User;
use App\Services\Contracts\IUserBankingService;

class UserBankingService implements IUserBankingService
{
    public function getTotalBalance(User $user): int
    {
        $totalBalance = 0;
        foreach ($user->userBanks as $bank) {
            $totalBalance += $bank->getBankService()->getAccountBalance($bank->iban)->balance;
        }

        return $totalBalance;
    }
}
