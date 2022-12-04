<?php

namespace App\Models;

use App\Enums\ContentTypeEnum;
use App\Enums\QuestionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'question_type' => QuestionTypeEnum::class,
        'content_type' => ContentTypeEnum::class,
    ];

}
