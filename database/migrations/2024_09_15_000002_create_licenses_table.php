<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('license_key')->unique();
            $table->enum('plan_type', ['basic', 'premium', 'enterprise'])->default('basic');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('max_users')->default(5);
            $table->integer('max_cattle')->default(500);
            $table->json('features')->nullable(); // Características habilitadas
            $table->enum('status', ['active', 'expired', 'suspended', 'cancelled'])->default('active');
            $table->decimal('price', 10, 2)->nullable();
            $table->string('payment_reference')->nullable();
            $table->timestamp('last_validated_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            
            $table->index(['company_id', 'status']);
            $table->index(['end_date', 'status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('licenses');
    }
};
