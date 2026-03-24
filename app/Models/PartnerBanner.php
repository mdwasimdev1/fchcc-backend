<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerBanner extends Model
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
        return $this->hasMany(PartnerBannerTranslation::class);
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $this->hasOne(PartnerBannerTranslation::class)
            ->where('locale', $locale);
    }
}
