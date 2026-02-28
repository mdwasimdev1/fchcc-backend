<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DynamicPage extends Model
{
     protected $fillable = [
            'page_title',
            'page_slug',
            'page_content',
            'status',
    ];
}
