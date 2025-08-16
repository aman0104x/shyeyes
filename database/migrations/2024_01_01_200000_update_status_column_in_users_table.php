<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // Disable automatic transaction for this migration
    public $withinTransaction = false;

    public function up()
    {
        // Step 1: Update existing data to match the new values
        DB::table('users')
            ->where('status', 'active')
            ->update(['status' => 'unblock']);

        DB::table('users')
            ->whereIn('status', ['inactive', 'banned', 'pending'])
            ->update(['status' => 'block']);

        // Step 2: Change the enum definition
        DB::statement("ALTER TABLE `users` MODIFY `status` ENUM('block','unblock') NOT NULL DEFAULT 'unblock'");
    }

    public function down(): void
    {
        // Step 1: Revert values
        DB::table('users')
            ->where('status', 'unblock')
            ->update(['status' => 'active']);

        DB::table('users')
            ->where('status', 'block')
            ->update(['status' => 'inactive']);

        // Step 2: Revert enum
        DB::statement("ALTER TABLE `users` MODIFY `status` ENUM('active','inactive','pending','banned') NOT NULL DEFAULT 'active'");
    }
};
