<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'title',
        'balance',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
