<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Contracts\IUserBankingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class UserController
{
    public function __construct(
        protected IUserBankingService $userBankingService
    )
    {}

    public function getBalance()
    {
        $user = Auth::user();

        return response()->json([
            'status'  => 'success',
            'message' => 'operation success',
            'data'    => [
                'balance' => $this->userBankingService->getTotalBalance($user)
            ]
        ]);
    }
}
