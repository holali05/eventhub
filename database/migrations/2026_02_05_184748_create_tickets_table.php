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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            // Lien vers le type de ticket (VIP, Standard...)
            $table->foreignId('ticket_type_id')->constrained()->onDelete('cascade');
            
            // Informations de l'acheteur (Client)
            $table->string('customer_name');
            $table->string('customer_whatsapp');
            $table->string('customer_email');
            
            // Sécurité et QR Code
            $table->string('unique_hash')->unique(); // Le code unique pour le QR Code
            $table->boolean('is_scanned')->default(false); // Pour savoir si le billet a déjà été utilisé
            $table->timestamp('scanned_at')->nullable(); // Heure du scan à l'entrée
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};