<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['event_date'];

    public function translations()
    {
        return $this->hasMany(EventTranslation::class);
    }

    public function translation($locale)
    {
        return $this->hasOne(EventTranslation::class)
            ->where('locale', $locale);
    }
}
