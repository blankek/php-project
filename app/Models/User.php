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

#[Fillable(['login', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'login',
        'password',
        'role',
    ];
// Константы для ролей
    public const ROLE_READER = 'reader';
    public const ROLE_EDITOR = 'editor';
    public const ROLE_ADMIN = 'admin';

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
        ];
    }

    public function username()
    {
        return 'login'; // its поле для аутентификации
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
}
