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
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            // Lien avec l'événement
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            
            $table->text('message'); // Le message personnalisé
            $table->string('frequency'); // 'daily', 'weekly', 'monthly'
            
            $table->timestamp('last_sent_at')->nullable(); // Utile pour que le script sache quand il a tourné pour la dernière fois
            $table->boolean('is_active')->default(true); // Pour permettre à l'organisateur de stopper les relances
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};