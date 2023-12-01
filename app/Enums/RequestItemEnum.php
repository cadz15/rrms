<?php

namespace App\Enums;

enum RequestItemEnum : int
{
    case DECLINED = 0;
    case PENDING = 1;
    case APPROVED = 2;
}
