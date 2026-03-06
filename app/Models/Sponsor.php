<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
     protected $fillable = [
        'logo',
        'website_url',
        'status'
    ];

    public function translations()
    {
        return $this->hasMany(SponsorTranslation::class);
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $this->hasOne(SponsorTranslation::class)
            ->where('locale', $locale);
    }
}
