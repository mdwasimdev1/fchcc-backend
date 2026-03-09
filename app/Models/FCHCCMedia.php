<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FCHCCMedia extends Model
{ 
    protected $fillable = ['image', 'status'];

    public function translations()
    {
        return $this->hasMany(FCHCCMediaTranslation::class);
    }
}
