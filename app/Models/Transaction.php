<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];
    protected $fillable = [
        'wallet_id',
        'is_incoming',
        'is_fraudulent',
        'amount',
        'reference',
        'payer',
        'beneficiary',
    ];

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function getDateString(): string
    {
        return $this->created_at->toDateString();
    }

    public function getFormattedAmount(): string
    {
        return $this->is_incoming ?
            '$ '.number_format($this->amount, 2) :
            '-$ '.number_format($this->amount, 2);
    }
}
