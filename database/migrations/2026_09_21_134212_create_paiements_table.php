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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('serveuse_id')->constrained('serveuses')->onDelete('cascade');
            $table->foreignId('boisson_id')->constrained('boissons')->onDelete('cascade');
            $table->integer('quantite');
            $table->decimal('montant', 8, 2);
            $table->timestamp('date_paiement');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
