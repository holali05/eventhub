<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('whatsapp_lists', function (Blueprint $table) {
            $table->string('frequency')->default('daily'); // daily, weekly
            $table->timestamp('last_sent_at')->nullable(); // Pour ne pas renvoyer trop vite
            $table->boolean('is_active')->default(true);   // Pour désactiver un contact si besoin
        });
    }

    public function down(): void
    {
        Schema::table('whatsapp_lists', function (Blueprint $table) {
            $table->dropColumn(['frequency', 'last_sent_at', 'is_active']);
        });
    }
};