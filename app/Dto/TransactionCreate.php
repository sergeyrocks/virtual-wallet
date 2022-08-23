<?php

namespace App\Dto;

class TransactionCreate
{
    public function __construct(
        public float|int $amount,
        public string $reference,
        public bool $is_incoming = false,
        public string|null $payer = null,
        public string|null $beneficiary = null,
    ) {
    }
}
