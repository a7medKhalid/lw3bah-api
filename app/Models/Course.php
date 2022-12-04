<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'course_has_tags');
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

}
