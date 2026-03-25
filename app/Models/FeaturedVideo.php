<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturedVideo extends Model
{

    protected $fillable = [
        'title',
        'video_file',
        'status',
    ];
}
