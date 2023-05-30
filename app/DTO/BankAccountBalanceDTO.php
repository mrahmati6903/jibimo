<?php

namespace App\DTO;

class BankAccountBalanceDTO
{
    public function __construct(
        public readonly string $bankName,
        public readonly string $iban,
        public readonly int $balance
    )
    {}
}
