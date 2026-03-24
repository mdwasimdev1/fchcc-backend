<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityBanner extends Model
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
        return $this->hasMany(CommunityBannerTranslation::class);
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $this->hasOne(CommunityBannerTranslation::class)
            ->where('locale', $locale);
    }

}
