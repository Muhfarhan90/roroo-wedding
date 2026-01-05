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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('bride_name');
            $table->string('groom_name');
            $table->string('bride_phone');
            $table->string('groom_phone');
            $table->text('bride_address')->nullable();
            $table->text('groom_address')->nullable();
            $table->string('bride_parents')->nullable();
            $table->string('groom_parents')->nullable();
            $table->date('akad_date')->nullable();
            $table->time('akad_time')->nullable();
            $table->time('akad_end_time')->nullable();
            $table->date('reception_date')->nullable();
            $table->time('reception_time')->nullable();
            $table->time('reception_end_time')->nullable();
            $table->text('event_location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
