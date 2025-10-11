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
        Schema::table('cattles', function (Blueprint $table) {
            $table->unsignedBigInteger('guide_id')->nullable()->after('classification_id');
            
            // Índice para mejorar el rendimiento
            $table->index('guide_id');
            
            // Llave foránea
            $table->foreign('guide_id')->references('id')->on('guides')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cattles', function (Blueprint $table) {
            $table->dropForeign(['guide_id']);
            $table->dropIndex(['guide_id']);
            $table->dropColumn('guide_id');
        });
    }
};
