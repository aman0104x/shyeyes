<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'unique_id',
        'f_name',
        'l_name',
        'email',
        'phone',
        'password',
        'dob',
        'img',
        'age',
        'gender',
        'location',
        'about',
        'status'
    ];

    protected $hidden = ['password'];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return trim("{$this->f_name} {$this->l_name}");
    }

    // Message requests sent by this user
    public function sentMessageRequests()
    {
        return $this->hasMany(MessageRequest::class, 'sender_id');
    }

    // Message requests received by this user
    public function receivedMessageRequests()
    {
        return $this->hasMany(MessageRequest::class, 'receiver_id');
    }

    // Messages sent by this user
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    // Messages received by this user
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get all likes this user has given
     */
    public function likesGiven()
    {
        return $this->hasMany(UserLike::class, 'liker_id');
    }

    /**
     * Get all likes this user has received
     */
    public function likesReceived()
    {
        return $this->hasMany(UserLike::class, 'liked_id');
    }

    /**
     * Get users this user has liked
     */
    public function likedUsers()
    {
        return $this->belongsToMany(User::class, 'user_likes', 'liker_id', 'liked_id');
    }

    /**
     * Get users who liked this user
     */
    public function likers()
    {
        return $this->belongsToMany(User::class, 'user_likes', 'liked_id', 'liker_id');
    }
}
