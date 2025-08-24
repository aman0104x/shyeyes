<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_settings', function (Blueprint $table) {
            $table->id();
            $table->string('qr_code')->nullable()->comment('QR code image path');
            $table->string('upi')->nullable()->comment('UPI ID');
            $table->string('phone_number')->nullable()->comment('Phone number');
            $table->string('holder_name')->nullable()->comment('Account holder name');
            $table->string('bank_name')->nullable()->comment('Bank name');
            $table->string('account_number')->nullable()->comment('Bank account number');
            $table->string('ifsc_code')->nullable()->comment('IFSC code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_settings');
    }
};
