<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

#[Fillable(['login', 'password', 'role', 'bio', 'gender', 'avatar'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'login',
        'password',
        'role',
        'bio',
        'gender',
        'avatar',
    ];

    public const ROLE_READER = 'reader';
    public const ROLE_EDITOR = 'editor';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MODERATOR = 'moderator';

    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'role' => 'string',
            'bio' => 'string',
            'gender' => 'string',
            'avatar' => 'string',
        ];
    }

    public function username()
    {
        return 'login';
    }

    public function isReader(): bool
    {
        return $this->role === self::ROLE_READER;
    }

    public function isEditor(): bool
    {
        return $this->role === self::ROLE_EDITOR;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isModerator(): bool
    {
        return $this->role === self::ROLE_MODERATOR;
    }

    public function canEdit(): bool
    {
        return $this->isEditor() || $this->isAdmin();
    }

    public function canManage(): bool
    {
        return $this->isAdmin();
    }

    public function postComments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_user_likes');
    }

    public function canInteract(): bool
    {
        return $this->isReader()
            || $this->isEditor()
            || $this->isAdmin()
            || $this->isModerator();
    }
    
    public function getAvatarUrl(): string
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }

        return asset('images/default-avatar.png');
    }

    public function getFormattedCreatedAt(): string
    {
        return $this->created_at->format('d.m.Y');
    }
}

