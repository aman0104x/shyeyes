<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('liker_id');
            $table->unsignedBigInteger('liked_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('liker_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('liked_id')->references('id')->on('users')->onDelete('cascade');

            // Ensure a user can't like the same user multiple times
            $table->unique(['liker_id', 'liked_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('user_likes');
    }
};
