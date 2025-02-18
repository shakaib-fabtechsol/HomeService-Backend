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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('call_pro');
            $table->bigInteger('text_pro');
            $table->bigInteger('instant_chat');
            $table->bigInteger('email_pro');
            $table->bigInteger('get_direction');
            $table->bigInteger('referral_direction');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};