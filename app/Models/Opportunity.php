<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Opportunity extends Model {
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public function translations() { return $this->hasMany(OpportunityTranslation::class, "opportunity_id"); }
    public function getTitleAttribute() { $t = $this->translations->where("locale", "en")->first(); return $t ? $t->title : "Untitled"; }
    public function getDescriptionAttribute() { $t = $this->translations->where("locale", "en")->first(); return $t ? ($t->short_description ?? "") : ""; }
}