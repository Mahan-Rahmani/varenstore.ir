<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case UNPAID = 'unpaid';
    case PAID = 'paid';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';

    public function badgeColor(): string
    {
        return match ($this) {
            self::UNPAID => 'bg-amber-100 text-amber-800 border-amber-300',
            self::PAID => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            self::FAILED => 'bg-rose-100 text-rose-800 border-rose-300',
            self::REFUNDED => 'bg-slate-100 text-slate-800 border-slate-300',
        };
    }
}
