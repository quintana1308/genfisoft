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
        // Agregar company_id a tabla cattles
        Schema::table('cattles', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('user_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'user_id']);
        });

        // Agregar company_id a tabla categories
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('user_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'user_id']);
        });

        // Agregar company_id a tabla herds
        Schema::table('herds', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('user_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'user_id']);
        });

        // Agregar company_id a tabla owners
        Schema::table('owners', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('user_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'user_id']);
        });

        // Agregar company_id a tabla products
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('user_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'user_id']);
        });

        // Agregar company_id a tabla veterinarians
        Schema::table('veterinarians', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('user_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'user_id']);
        });

        // Agregar company_id a tabla workmen
        Schema::table('workmen', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('user_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'user_id']);
        });

        // Agregar company_id a tabla deaths
        Schema::table('deaths', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('user_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'user_id']);
        });

        // Agregar company_id a tabla estates
        Schema::table('estates', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('user_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'user_id']);
        });

        // Agregar company_id a tabla inputs
        Schema::table('inputs', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('user_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'user_id']);
        });

        // Agregar company_id a tabla cause_entries
        Schema::table('cause_entries', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('user_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'user_id']);
        });

        // Agregar company_id a tabla colors
        Schema::table('colors', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('user_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'user_id']);
        });

        // Agregar company_id a tabla classifications
        Schema::table('classifications', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('user_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'user_id']);
        });

        // Agregar company_id a tabla status_productives
        Schema::table('status_productives', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('user_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'user_id']);
        });

        // Agregar company_id a tabla status_reproductives
        Schema::table('status_reproductives', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->after('user_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar foreign keys y columnas en orden inverso
        $tables = [
            'status_reproductives',
            'status_productives', 
            'classifications',
            'colors',
            'cause_entries',
            'inputs',
            'estates',
            'deaths',
            'workmen',
            'veterinarians',
            'products',
            'owners',
            'herds',
            'categories',
            'cattles'
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropForeign([$table . '_company_id_foreign']);
                $table->dropColumn('company_id');
            });
        }
    }
};
