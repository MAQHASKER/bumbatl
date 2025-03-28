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
        Schema::create('team_invites', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique(); // Уникальный идентификатор приглашения
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('inviter_id')->constrained('users')->onDelete('cascade');
            $table->string('email')->nullable(); // Email приглашенного пользователя
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // ID пользователя, если он уже зарегистрирован
            $table->boolean('is_accepted')->default(false);
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_invites');
    }
};
