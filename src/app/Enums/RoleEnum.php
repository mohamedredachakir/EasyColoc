<?php

namespace App\Enums;

enum RoleEnum : string
{
    case ADMIN = "admin";
    case OWNER = "owner";
    case MEMBER = "member";
    case GUEST = "guest";
}
