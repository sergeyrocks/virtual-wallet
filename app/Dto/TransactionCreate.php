<?php

namespace App\Dto;

use Livewire\Wireable;

class TransactionCreate implements Wireable
{
    public function __construct(
        public float|int|string $amount,
        public string $reference,
        public bool $is_incoming = false,
        public string|null $payer = null,
        public string|null $beneficiary = null,
    ) {
    }

    public function toLivewire(): array
    {
        return $this->toArray();
    }

    public static function fromLivewire($value): TransactionCreate
    {
        return new self(...$value);
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
