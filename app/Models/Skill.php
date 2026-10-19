<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function translations()
    {
        return $this->hasMany(SkillTranslation::class);
    }

    public function getTitleAttribute()
    {
        $trans = $this->translations->where("locale", "en")->first();
        if ($trans && $trans->title) return $trans->title;
        $anyTrans = $this->translations->whereNotNull("title")->where("title", "!=", "")->first();
        return $anyTrans ? $anyTrans->title : "Untitled Skill";
    }

    

    

    

    public function getDescriptionAttribute()
    {
        $trans = $this->translations->where("locale", "en")->first() ?? $this->translations->first();
        if (!$trans) return "";
        return $trans->full_description ?? $trans->content ?? $trans->short_description ?? $trans->description ?? "";
    }
}
