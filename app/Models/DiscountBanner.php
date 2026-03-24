<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountBanner extends Model
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
        return $this->hasMany(DiscountBannerTranslation::class);
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $this->hasOne(DiscountBannerTranslation::class)
            ->where('locale', $locale);
    }

}
