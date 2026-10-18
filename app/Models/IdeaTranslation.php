<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdeaTranslation extends Model
{
    use HasFactory;
    protected $fillable = [
        'idea_id', 'locale', 'title', 'short_description', 'full_description',
        'target_customers', 'requirements', 'materials', 'steps', 'risks', 'tips',
        'profitability_notes', 'meta_title', 'meta_description', 'keywords',
        'og_title', 'og_description', 'og_image',
    ];

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }
}