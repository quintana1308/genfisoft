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
        Schema::create('milk_production', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('cattle_id')->nullable();
            $table->date('production_date');
            $table->decimal('liters', 10, 2);
            $table->decimal('price_per_liter', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->text('observations')->nullable();
            $table->timestamps();
            
            $table->index(['company_id', 'cattle_id', 'production_date']);
            $table->unique(['cattle_id', 'production_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milk_production');
    }
};
