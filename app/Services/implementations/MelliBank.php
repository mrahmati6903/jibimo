<?php

namespace App\Services\implementations;

use App\DTO\BankAccountBalanceDTO;
use App\Exceptions\BankServiceCallException;
use App\Services\Contracts\IBankService;
use Illuminate\Support\Facades\Http;

class MelliBank implements IBankService
{
    const BANK_NAME = 'melli';
    const API_ADDRESS = 'https://mellibank.ir';

    public function getBankName(): string
    {
        return self::BANK_NAME;
    }

    public function getAccountBalance(string $iban): BankAccountBalanceDTO
    {
        try {
            $response = Http::get(self::API_ADDRESS . '/api/balance');
            if (200 != $response->status()) {
                throw new BankServiceCallException($response->body());
            }

            return new BankAccountBalanceDTO($this->getBankName(), $iban, $response->json()['amount']);
        } catch (\Exception $e) {
            throw new BankServiceCallException($e->getMessage());
        }
    }
}
