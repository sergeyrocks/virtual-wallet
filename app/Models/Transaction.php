<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{

    use SoftDeletes;

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

    /**
     * @return string
     */
    public function getDateString(): string
    {
        return $this->created_at->toDateString();
    }

    /**
     * @return string
     */
    public function getFormattedAmount(): string
    {
        return $this->is_incoming ?
            '$ ' . number_format($this->amount, 2) :
            '-$ ' . number_format($this->amount, 2);
    }
}
