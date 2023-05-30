<?php

namespace App\Services\Contracts;

use App\DTO\BankAccountBalanceDTO;
use App\Exceptions\BankServiceCallException;

interface IBankService
{
    /**
     * Get current bank name
     * @return string
     */
    public function getBankName(): string;

    /**
     * Get account balance by account iban
     * @param string $iban
     * @return BankAccountBalanceDTO
     * @throws BankServiceCallException
     */
    public function getAccountBalance(string $iban): BankAccountBalanceDTO;
}
