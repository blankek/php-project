<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'status',
        'published_at',
        'likes',
        'comments',
        'picture',
    ];

    protected $dates = [
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function postComments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function likesRelation()
    {
        return $this->belongsToMany(User::class, 'post_user_likes')->using(PostLike::class);
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likesRelation()->where('user_id', $user->id)->exists();
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
}
