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
        Schema::create('whatsapp_lists', function (Blueprint $table) {
            $table->id();
            // Lien avec l'événement
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            
            $table->string('phone_number'); // Format international (ex: 229XXXXXXXX)
            $table->string('contact_name')->nullable(); // Optionnel : pour personnaliser le message
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_lists');
    }
};