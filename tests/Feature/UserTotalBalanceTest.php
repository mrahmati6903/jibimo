<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserBank;
use App\Services\implementations\MelliBank;
use App\Services\implementations\PasargadBank;
use App\Services\implementations\SaderatBank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UserTotalBalanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_total_balance()
    {
        $user = User::factory()
            ->has(
                UserBank::factory()->state(['bank_name' => 'melli'])
            )
            ->has(
                UserBank::factory()->state(['bank_name' => 'saderat'])
            )
            ->has(
                UserBank::factory()->state(['bank_name' => 'pasargad'])
            )
            ->create();

        Http::fake([
            MelliBank::API_ADDRESS    . '/*' => Http::response(['amount'  => 10000]),
            SaderatBank::API_ADDRESS  . '/*' => Http::response(['value'   => 20000]),
            PasargadBank::API_ADDRESS . '/*' => Http::response(['balance' => 30000]),
        ]);

        $response = $this->actingAs($user)->get('/api/user/balance');

        $response->assertStatus(200);
        $response->assertJson([
            'status'  => 'success',
            'message' => 'operation success',
            'data'    => [
                'balance' => 60000
            ]
        ]);
    }
}
