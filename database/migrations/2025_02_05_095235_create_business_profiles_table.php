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
        Schema::create('business_profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('business_name')->nullable();
            $table->string('business_logo')->nullable();
            $table->string('location')->nullable();
            $table->text('about')->nullable();
            $table->string('business_primary_category')->nullable();
            $table->text('business_secondary_categories')->nullable();
            $table->string('website')->nullable();

            $table->text('technician_photo')->nullable();
            $table->text('vehicle_photo')->nullable();
            $table->text('facility_photo')->nullable();
            $table->text('project_photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_profiles');
    }
};
