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

        $lastStreakDate = $streaks->first()->created_at;

        foreach ($streaks as $streak){
            if($streak->created_at->diffInDays($lastStreakDate) == 1){
                $streakLength++;
            }else{
                break;
            }
            $lastStreakDate = $streak->created_at;
        }

        $user->streak_length = $streakLength;

        return $user;

    }
}
