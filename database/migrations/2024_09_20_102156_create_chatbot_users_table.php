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
        Schema::create('chatbot_users', function (Blueprint $table) {
            $table->unsignedBigInteger('chat_id')->primary();
            $table->string('username')->unique();
            $table->boolean('is_bot')->default(false);
            $table->boolean('is_premium')->default(false);
            $table->boolean('has_subscription')->default(false);
            $table->bigInteger('balance')->default(0);
            $table->integer('remaining_requests_count')->default(20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_users');
    }
};
