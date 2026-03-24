<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartnerBannerTranslation extends Model
{
  protected $fillable = [
        'partner_banner_id',
        'locale',
        'title',
        'description',
        'button_text',
    ];

    public function banner()
    {
        return $this->belongsTo(PartnerBanner::class, 'partner_banner_id');
    }
}
