<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {

        return $user->role === UserRoleEnum::teacher;
    }

    public function update(User $user, Course $course)
    {
        return $user->role === UserRoleEnum::teacher && $user->_id === $course->teacher_id;
    }

    public function delete(User $user, Course $course)
    {
        return $user->role === UserRoleEnum::teacher && $user->_id === $course->teacher_id;
    }

}
