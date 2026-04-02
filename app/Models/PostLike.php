<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PostLike extends Pivot
{
    protected $table = 'post_user_likes';

    protected $fillable = [
        'post_id',
        'user_id',
    ];
}