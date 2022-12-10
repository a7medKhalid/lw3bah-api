<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewMyCourses extends Controller
{

    public function __invoke(Request $request)
    {
        //authorize request
        $user = $request->user();
        $courses = $user->courses()->get();

        return $courses;
    }
}
