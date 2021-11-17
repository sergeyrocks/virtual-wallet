<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $wallet_id
 * @property bool $is_incoming
 * @property bool $is_fraudulent
 * @property float $amount
 * @property string $reference
 * @property string $payer
 * @property string $beneficiary
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Wallet $wallet
 */
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

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
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
