<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function translations()
    {
        return $this->hasMany(PhotoTranslation::class);
    }

    public function getTitleAttribute()
    {
        $trans = $this->translations->where("locale", "en")->first();
        return $trans ? $trans->title : "Untitled Photo";
    }

    public function getDescriptionAttribute()
    {
        $trans = $this->translations->where("locale", "en")->first();
        return $trans ? $trans->description : "";
    }
}