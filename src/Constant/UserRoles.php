<?php

namespace App\Constant;

use App\Constant\Trait\EnumToArrayTrait;

enum UserRoles: string
{
    use EnumToArrayTrait;

    case ROLE_USER = 'ROLE_USER';

    case ROLE_ADMIN = 'ROLE_ADMIN';
}