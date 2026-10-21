<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Idea extends Model {
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public function translations() { return $this->hasMany(IdeaTranslation::class); }
    public function getTitleAttribute() { $t = $this->translations->where("locale", "en")->first(); return $t ? $t->title : "Untitled"; }
    public function getDescriptionAttribute() { $t = $this->translations->where("locale", "en")->first(); return $t ? ($t->description ?? "") : ""; }


    public function category() {
        return $this->belongsTo(\App\Models\Category::class);
    }
}