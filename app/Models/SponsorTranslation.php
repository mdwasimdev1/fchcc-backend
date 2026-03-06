<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SponsorTranslation extends Model
{
     protected $fillable = [
        'sponsor_id',
        'locale',
        'name',
        'description'
    ];

    public function sponsor()
    {
        return $this->belongsTo(Sponsor::class);
    }
}
