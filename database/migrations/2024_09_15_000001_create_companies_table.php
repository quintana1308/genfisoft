<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('business_name')->nullable();
            $table->string('tax_id')->unique()->nullable(); // RIF/NIT
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->default('Venezuela');
            $table->string('logo')->nullable();
            $table->json('settings')->nullable(); // Configuraciones específicas
            $table->bigInteger('status_id')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            
            $table->index(['status_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
