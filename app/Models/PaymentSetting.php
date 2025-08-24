<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'qr_code',
        'upi',
        'phone_number',
        'holder_name',
        'bank_name',
        'account_number',
        'ifsc_code',
    ];
}
