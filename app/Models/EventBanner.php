<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventBanner extends Model
{
    protected $fillable = [
        'image',
        'button_url',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function translations()
    {
        return $this->hasMany(EventBannerTranslation::class);
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->hasOne(EventBannerTranslation::class)->where('locale', $locale);
    }
}
