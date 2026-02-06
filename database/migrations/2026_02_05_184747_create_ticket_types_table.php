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
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id();
            // Lien avec l'événement
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            
            $table->string('name'); // Ex: "VIP", "Standard", "Étudiant"
            $table->decimal('price', 10, 2)->default(0); // Prix du ticket
            $table->integer('total_quantity'); // Nombre total de places mises en vente
            $table->integer('remaining_quantity'); // Nombre de places restantes (pour les stats)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_types');
    }
};