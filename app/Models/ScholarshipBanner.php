<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScholarshipBanner extends Model
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
        return $this->hasMany(ScholarshipBannerTranslation::class);
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $this->hasOne(ScholarshipBannerTranslation::class)
            ->where('locale', $locale);
    }

}
