<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'category_id', 'source_type', 'file_path', 'external_url', 'external_video_id',
        'thumbnail_path', 'original_filename', 'file_size', 'mime_type', 'duration_seconds',
        'is_featured', 'is_published', 'published_at', 'views_count', 'likes_count', 'comments_count', 'sort_order'
    ];
    public function translations() { return $this->hasMany(VideoTranslation::class); }
}