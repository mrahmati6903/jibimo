<?php

namespace App\Models;

use App\Exceptions\BankServiceNotFound;
use App\Services\Contracts\IBankService;
use App\Services\implementations\MelliBank;
use App\Services\implementations\PasargadBank;
use App\Services\implementations\SaderatBank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;

class UserBank extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'bank_name'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get specific IBankService implementation based on bank_name field
     * @return IBankService
     * @throws BankServiceNotFound
     */
    public function getBankService(): IBankService
    {
        return match ($this->bank_name) {
            'melli'    => App::make(MelliBank::class),
            'saderat'  => App::make(SaderatBank::class),
            'pasargad' => App::make(PasargadBank::class),
            default    => throw new BankServiceNotFound(),
        };
    }
}
