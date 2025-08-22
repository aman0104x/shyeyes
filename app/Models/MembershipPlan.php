<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'price',
        'monthly_price',
        'features',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'monthly_price' => 'decimal:2',
    ];

    /**
     * Get the status badge class based on status.
     *
     * @return string
     */
    public function getStatusBadgeAttribute()
    {
        return $this->status === 'active'
            ? 'bg-green-100 text-green-800'
            : 'bg-red-100 text-red-800';
    }

    /**
     * Get the status text.
     *
     * @return string
     */
    public function getStatusTextAttribute()
    {
        return $this->status === 'active' ? 'Active' : 'Inactive';
    }

    /**
     * Scope a query to only include active plans.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
