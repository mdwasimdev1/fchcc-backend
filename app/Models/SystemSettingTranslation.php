<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSettingTranslation extends Model
{
protected $fillable = [
        'system_setting_id',
        'locale',
        'system_title',
        'system_short_title',
        'company_name',
        'tag_line',
        'copyright_text',
        'admin_title',
        'admin_short_title',
        'admin_copyright_text',
    ];
}
