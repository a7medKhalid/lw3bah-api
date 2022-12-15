<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetProfile extends Controller
{

    public function __invoke(Request $request)
    {
        $user = $request->user();


        $streaks = $user->streaks;
        $streakLength = 0;


        if ($streaks->count() > 0) {
            $lastStreakDate = $streaks->first()->created_at;

            //if streak is less than 24 hours
            if ($lastStreakDate->diffInHours(now()) < 24) {
                $streakLength = 1;
            }

            foreach ($streaks as $streak){

                if($streak->created_at->diffInHours($lastStreakDate) < 24){
                    $streakLength++;
                }else{
                    break;
                }
                $lastStreakDate = $streak->created_at;
            }

        }

        $user->streak_length = $streakLength;




        return $user;

    }
}
