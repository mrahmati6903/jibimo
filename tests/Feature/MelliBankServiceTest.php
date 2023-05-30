<?php

namespace Tests\Feature;

use App\DTO\BankAccountBalanceDTO;
use App\Exceptions\BankServiceCallException;
use App\Services\implementations\MelliBank;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MelliBankServiceTest extends TestCase
{
    public function test_getAccountBalance_method_work_correctly()
    {
        $melliBankService = new MelliBank();
        Http::fake([
            MelliBank::API_ADDRESS    . '/*' => Http::response(['amount'  => 10000]),
        ]);
        $balance = $melliBankService->getAccountBalance(fake()->iban('IR'));
        $this->assertInstanceOf(BankAccountBalanceDTO::class, $balance);
        $this->assertEquals(10000, $balance->balance);
    }

    public function test_getAccountBalance_method_encountered_an_error()
    {
        $melliBankService = new MelliBank();
        $this->expectException(BankServiceCallException::class);
        $melliBankService->getAccountBalance(fake()->iban('IR'));

        Http::fake([
            MelliBank::API_ADDRESS    . '/*' => Http::response(['message' => 'internal bank error'], 500),
        ]);
        $melliBankService->getAccountBalance(fake()->iban('IR'));
    }
}
