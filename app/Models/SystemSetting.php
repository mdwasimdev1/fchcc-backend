<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
     protected $fillable = [
        'logo',
        'minilogo',
        'favicon',
        'phone_code',
        'phone_number',
        'whatsapp',
        'email',
        'time_zone',
        'admin_logo',
        'admin_mini_logo',
        'admin_favicon',
    ];



public function translations()
    {
        return $this->hasMany(SystemSettingTranslation::class);
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        return $this->hasOne(SystemSettingTranslation::class)
            ->where('locale', $locale);
    }


}
