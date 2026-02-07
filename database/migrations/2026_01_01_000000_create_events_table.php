<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            // L'organisateur qui crée l'événement
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Infos de base
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location');
            
            // Date, Heure et Capacité
            $table->date('event_date'); 
            $table->time('event_time');
            $table->integer('capacity')->default(0); 
            
            // Fichiers et Admin
            $table->string('ticket_template_path')->nullable();
            $table->string('admin_status')->default('pending'); // pending, approved, rejected
            $table->boolean('is_published')->default(false);
            $table->text('rejection_reason')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};