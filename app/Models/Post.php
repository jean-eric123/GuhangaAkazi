<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;


    //

    public function getDescriptionAttribute()
    {
        $trans = $this->translations->where("locale", "en")->first() ?? $this->translations->first();
        if (!$trans) return "";
        return $trans->full_description ?? $trans->content ?? $trans->short_description ?? $trans->description ?? "";
    }

    public function translations()
    {
        return $this->hasMany(PostTranslation::class, "post_id");
    }
}
