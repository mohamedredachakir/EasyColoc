<?php

namespace App\enum;

enum RoleEnum : string
{
    case USER = 'user';
    case ADMIN = 'admin';
    case OWNER = 'owner';
    case MEMBER = 'member';
}
