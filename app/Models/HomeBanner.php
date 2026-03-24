<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeBanner extends Model
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
        return $this->hasMany(HomeBannerTranslation::class);
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $this->hasOne(HomeBannerTranslation::class)
            ->where('locale', $locale);
    }

}
