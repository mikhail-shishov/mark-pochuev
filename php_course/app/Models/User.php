<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['name', 'last_name', 'email', 'password', 'role_id', 'avatar_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_MODERATOR = 'moderator';
    const ROLE_USER = 'user';

    public function avatar()
    {
        return $this->belongsTo(Media::class, 'avatar_id');
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return $this->avatar->url;
        }

        return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?s=200&d=mp';
    }

    public function isAdmin(): bool
    {
        return $this->role?->slug === self::ROLE_ADMIN;
    }

    public function isModerator(): bool
    {
        return $this->role?->slug === self::ROLE_MODERATOR;
    }

    public function isUser(): bool
    {
        return $this->role?->slug === self::ROLE_USER;
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function canManageUsers(): bool
    {
        return $this->isAdmin();
    }

    public function canManageArticles(): bool
    {
        return $this->isAdmin() || $this->isModerator();
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
