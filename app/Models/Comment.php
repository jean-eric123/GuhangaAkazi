<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    // Allow mass assignment for the database columns
    protected $guarded = [];

    // Connect the Comment back to the Idea, Video, Photo, etc.
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}