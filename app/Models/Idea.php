<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Idea extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'slug',
        'cover_image',
        'capital',
        'capital_min',
        'capital_max',
        'operating_costs',
        'expected_revenue',
        'expected_profit',
        'currency',
        'difficulty_level',
        'time_to_start',
        'is_featured',
        'is_published',
        'published_at',
        'views_count',
        'likes_count',
        'comments_count',
        'sort_order',
    ];

    protected $casts = [
        'capital'          => 'decimal:2',
        'capital_min'      => 'decimal:2',
        'capital_max'      => 'decimal:2',
        'operating_costs'  => 'decimal:2',
        'expected_revenue' => 'decimal:2',
        'expected_profit'  => 'decimal:2',
        'is_featured'      => 'boolean',
        'is_published'     => 'boolean',
        'published_at'     => 'datetime',
        'views_count'      => 'integer',
        'likes_count'      => 'integer',
        'comments_count'   => 'integer',
        'sort_order'       => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function translations()
    {
        return $this->hasMany(IdeaTranslation::class);
    }

    public function translation(?string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->firstWhere('locale', 'en');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
