<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class GetPublishedTags extends Controller
{

    public function __invoke(Request $request)
    {
        $tags = Tag::where('is_published', true)->get();

        return $tags;
    }
}
