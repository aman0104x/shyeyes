<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'liker_id',
        'liked_id'
    ];

    /**
     * Get the user who liked
     */
    public function liker()
    {
        return $this->belongsTo(User::class, 'liker_id');
    }

    /**
     * Get the user who was liked
     */
    public function liked()
    {
        return $this->belongsTo(User::class, 'liked_id');
    }
}
