<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityBannerTranslation extends Model
{
    protected $fillable = [
        'community_banner_id',
        'locale',
        'title',
        'description',
        'button_text',
    ];

    public function banner()
    {
        return $this->belongsTo(CommunityBanner::class, 'community_banner_id');
    }

}
