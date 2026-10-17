<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'file_path',
        'thumbnail_path',
        'original_filename',
        'file_size',
        'mime_type',
        'width',
        'height',
        'is_featured',
        'is_published',
        'published_at',
        'views_count',
        'likes_count',
        'comments_count',
        'sort_order',
    ];

    protected $casts = [
        'is_featured'  => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views_count'  => 'integer',
        'likes_count'  => 'integer',
        'comments_count' => 'integer',
        'sort_order'   => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function translations()
    {
        return $this->hasMany(PhotoTranslation::class);
    }

    public function translation(?string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->translations->firstWhere('locale', $locale)
            ?? $this->translations->firstWhere('locale', 'en');
    }

    public function getUrlAttribute(): string
    {
        if (! $this->file_path) {
            return '';
        }
        if (preg_match('#^https?://#i', $this->file_path)) {
            return $this->file_path;
        }
        return asset('storage/' . ltrim($this->file_path, '/'));
    }
}
