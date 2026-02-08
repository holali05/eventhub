<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            
            $table->string('user_name');
            $table->string('user_email');
            $table->integer('tickets_count')->default(1);
            $table->string('status')->default('confirmé');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};