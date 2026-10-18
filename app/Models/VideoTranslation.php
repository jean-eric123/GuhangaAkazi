<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoTranslation extends Model
{
    use HasFactory;
    protected $fillable = ['video_id', 'locale', 'title', 'description', 'meta_title', 'meta_description', 'keywords'];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}