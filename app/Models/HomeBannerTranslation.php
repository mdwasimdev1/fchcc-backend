<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeBannerTranslation extends Model
{
    protected $fillable = [
        'home_banner_id',
        'locale',
        'title',
        'description',
        'button_text',
    ];

    public function banner()
    {
        return $this->belongsTo(HomeBanner::class, 'home_banner_id');
    }

}
