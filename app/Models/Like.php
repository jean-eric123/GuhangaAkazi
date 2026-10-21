<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Like extends Model
{
    // Allow mass assignment for the database columns
    protected $guarded = [];

    // Connect the Like back to the Idea, Video, Photo, etc.
    public function likeable(): MorphTo
    {
        return $this->morphTo();
    }
}