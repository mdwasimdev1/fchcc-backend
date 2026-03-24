<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountBannerTranslation extends Model
{
    protected $fillable = [
        'discount_banner_id',
        'locale',
        'title',
        'description',
        'button_text',
    ];

    public function discountBanner()
    {
        return $this->belongsTo(DiscountBanner::class);
    }

}
