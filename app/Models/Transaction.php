<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'membership_plan_id',
        'amount',
        'payment_method',
        'status',
        'screenshot',
    ];

    /**
     * Get the user associated with the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the membership plan associated with the transaction.
     */
    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class);
    }
}
