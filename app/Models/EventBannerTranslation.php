<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventBannerTranslation extends Model
{
    protected $fillable = [
        'event_banner_id',
        'locale',
        'title',
        'description',
        'button_text',
    ];

    public function banner()
    {
        return $this->belongsTo(EventBanner::class, 'event_banner_id');
    }
}
