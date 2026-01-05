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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('owner_name');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->json('banks')->nullable(); // Array of bank accounts [{bank_name, account_number, account_holder}]
            $table->json('social_media')->nullable(); // {instagram, facebook, tiktok, whatsapp, website}
            $table->text('description')->nullable();
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
