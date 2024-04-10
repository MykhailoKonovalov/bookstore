<?php

namespace App\Constant;

enum UserRoles: string
{
    case ROLE_USER = 'ROLE_USER';

    case ROLE_ADMIN = 'ROLE_ADMIN';
}