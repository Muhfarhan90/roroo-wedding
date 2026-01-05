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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');

            // Items and services as JSON
            $table->json('items')->nullable();

            // Financial information
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->json('payment_history')->nullable(); // Store all payment records
            $table->decimal('remaining_amount', 15, 2)->default(0);
            $table->string('payment_status')->default('Belum Lunas'); // Belum Lunas, Lunas

            // Decoration details as JSON
            $table->json('decorations')->nullable();

            // Additional notes
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
