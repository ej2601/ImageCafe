<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }


    public function likedImages()
    {
        return $this->belongsToMany(Image::class, 'likes', 'user_id', 'image_id')
            ->withTimestamps();
    }

    // Get all users who follow this user
    public function followers()
    {
        return $this->hasMany(Follower::class, 'followed_id', 'id');
    }

    // Get all users this user is following
    public function following()
    {
        return $this->hasMany(Follower::class, 'follower_id', 'id');
    }
}
