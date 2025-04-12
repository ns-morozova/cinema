<?php

namespace App\Enums;

enum SeatType: string
{
    case VIP = 'vip';
    case STANDART = 'standart';
    case DISABLED = 'disabled';
}
