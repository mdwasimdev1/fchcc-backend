<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScholarshipBannerTranslation extends Model
{
    protected $fillable = [
        'scholarship_banner_id',
        'locale',
        'title',
        'description',
        'button_text',
    ];

    public function banner()
    {
        return $this->belongsTo(ScholarshipBanner::class, 'scholarship_banner_id');
    }

}
