<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('user_profiles');

        if (!Schema::hasTable('profiles')) {
            Schema::create('profiles', function (Blueprint $table) {
                $table->id();

                $table->foreignId('user_id')
                    ->unique()
                    ->constrained('users')
                    ->onDelete('cascade');

                $table->string('role')->nullable();
                $table->string('current_status')->nullable();
                $table->string('affiliated_organization')->nullable();
                $table->date('date_of_birth')->nullable();
                $table->string('phone')->nullable();
                $table->text('description')->nullable();
                $table->string('location')->nullable();
                $table->string('profile_image')->nullable();

                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
