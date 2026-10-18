<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Idea extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function translations()
    {
        return $this->hasMany(IdeaTranslation::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getTitleAttribute()
    {
        $trans = $this->translations->where("locale", "en")->first();
        if ($trans && $trans->title) return $trans->title;
        $anyTrans = $this->translations->whereNotNull("title")->where("title", "!=", "")->first();
        return $anyTrans ? $anyTrans->title : "Untitled Idea";
    }

    public function getDescriptionAttribute()
    {
        $trans = $this->translations->where("locale", "en")->first();
        if ($trans && $trans->description) return $trans->description;
        $anyTrans = $this->translations->whereNotNull("description")->where("description", "!=", "")->first();
        return $anyTrans ? $anyTrans->description : "";
    }
}
