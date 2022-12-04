<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {

        return $user->role === 'teacher';
    }

    public function update(User $user, Course $course)
    {
        return $user->role === 'teacher' && $user->_id === $course->teacher_id;
    }

}
