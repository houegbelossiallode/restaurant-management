<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('distributions', function (Blueprint $table) {
            $table->index('date_distribution');
        });

        Schema::table('paiements', function (Blueprint $table) {
            $table->index('date_paiement');
        });
    }

    public function down(): void
    {
        Schema::table('distributions', function (Blueprint $table) {
            $table->dropIndex(['date_distribution']);
        });

        Schema::table('paiements', function (Blueprint $table) {
            $table->dropIndex(['date_paiement']);
        });
    }
};