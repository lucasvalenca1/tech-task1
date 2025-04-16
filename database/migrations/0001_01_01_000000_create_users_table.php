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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname'); // <-- ADDED
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone'); // <-- ADDED (adjust max length if needed ->string('phone', 20) )
            $table->string('country'); // <-- ADDED
            $table->string('gender'); // <-- ADDED (consider ->string('gender', 50) if options are long)
            // $table->string('selfie_path')->nullable(); // Add later if needed for image upload
            // $table->text('introduction')->nullable(); // Add later if needed
            $table->string('password');
            $table->rememberToken();
            $table->timestamps(); // Adds created_at and updated_at
        });

        // Keep these if they were present in your original migration file
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
        // End of optional tables (password_reset_tokens, sessions)
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        // Keep these if they were present in your original migration file
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        // End of optional tables
    }
};
