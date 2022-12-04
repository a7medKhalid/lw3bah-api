<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case admin = 'admin';
    case teacher = 'teacher';
    case student = 'student';
}
