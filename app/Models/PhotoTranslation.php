<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoTranslation extends Model
{
    use HasFactory;
    protected $fillable = [
        'photo_id', 'locale', 'title', 'description', 'alt_text',
        'meta_title', 'meta_description', 'keywords',
    ];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
}