<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'wallet_id',
        'is_incoming',
        'is_fraudulent',
        'amount',
        'reference',
        'payer',
        'beneficiary',
    ];

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
}
