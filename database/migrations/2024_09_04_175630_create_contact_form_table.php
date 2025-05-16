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
        Schema::create('contact_form', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email', 100);
            $table->string('subject', 50);
            $table->text('message');
            $table->enum('priority', ['HIGH', 'NORMAL', 'LOW'])
                ->default('NORMAL');
            $table->boolean('answered')->default(false);
            $table->string('locale', 2)->default('fa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_form');
    }
};
