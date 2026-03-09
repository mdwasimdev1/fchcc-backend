<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FCHCCMediaTranslation extends Model
{
    protected $fillable = ['f_c_h_c_c_media_id','locale','title','description'];

    public function media()
    {
        return $this->belongsTo(FCHCCMedia::class,'f_c_h_c_c_media_id');
    }
}
