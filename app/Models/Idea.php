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

    

    

    

    protected static function booted()
    {
        static::saved(function ($model) {
            if ($model->cover_image) {
                $ext = strtolower(pathinfo($model->cover_image, PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                    $photo = \App\Models\Photo::firstOrCreate(
                        ["file_path" => $model->cover_image],
                        ["is_published" => true]
                    );
                    $photo->translations()->updateOrCreate(
                        ["locale" => "en"],
                        ["title" => $model->title ?? "Untitled", "description" => $model->description ?? ""]
                    );
                }
            }
        });
    }

    public function getDescriptionAttribute()
    {
        $trans = $this->translations->where("locale", "en")->first() ?? $this->translations->first();
        if (!$trans) return "";
        return $trans->full_description ?? $trans->content ?? $trans->short_description ?? $trans->description ?? "";
    }
}
