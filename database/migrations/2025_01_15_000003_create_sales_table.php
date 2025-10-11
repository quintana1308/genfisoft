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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('company_id')->nullable();
            $table->bigInteger('cattle_id')->nullable();
            $table->decimal('sale_price', 10, 2);
            $table->date('sale_date');
            $table->text('observations')->nullable();
            $table->bigInteger('status_id')->default(1);
            $table->timestamp('created_at')->useCurrent();
            
            $table->index(['company_id', 'cattle_id']);
            $table->index('sale_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
