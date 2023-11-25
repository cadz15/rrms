<?php

namespace App\Enums;

enum RequestEnum : string
{
    case DECLINED = 'declined';
    case PENDING = 'pending';
    case FOR_PICK_UP = 'for_pick_up';
}
