<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function badgeColor(): string
    {
        return match ($this) {
            self::PENDING => 'bg-yellow-100 text-yellow-800 border-yellow-300',
            self::PROCESSING => 'bg-blue-100 text-blue-800 border-blue-300',
            self::COMPLETED => 'bg-green-100 text-green-800 border-green-300',
            self::CANCELLED => 'bg-red-100 text-red-800 border-red-300',
        };
    }
}
