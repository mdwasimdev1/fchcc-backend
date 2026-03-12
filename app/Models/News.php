<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = ['image', 'status'];

    public function translations()
    {
        return $this->hasMany(NewsTranslation::class);
    }
}
