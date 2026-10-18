<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use SoftDeletes;



    protected $fillable = [
        'category_id', 'file_path', 'thumbnail_path', 'original_filename',
        'file_size', 'mime_type', 'width', 'height', 'is_featured',
        'is_published', 'published_at', 'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function translations()
    {
        return $this->hasMany(PhotoTranslation::class);
    }
}