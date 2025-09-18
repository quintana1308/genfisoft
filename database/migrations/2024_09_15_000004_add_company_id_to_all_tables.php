<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Tablas principales del negocio
        $tables = [
            'cattles', 'categorys', 'herds', 'colors', 'classifications',
            'cause_entrys', 'status_reproductives', 'status_productives',
            'veterinarians', 'deaths', 'products', 'owners', 'inputs',
            'estates', 'workmans'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table_blueprint) {
                    $table_blueprint->unsignedBigInteger('company_id')->nullable()->after('id');
                    $table_blueprint->index(['company_id', 'status_id']);
                });
            }
        }
    }

    public function down()
    {
        $tables = [
            'cattles', 'categorys', 'herds', 'colors', 'classifications',
            'cause_entrys', 'status_reproductives', 'status_productives',
            'veterinarians', 'deaths', 'products', 'owners', 'inputs',
            'estates', 'workmans'
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table_blueprint) {
                    $table_blueprint->dropForeign(['company_id']);
                    $table_blueprint->dropColumn('company_id');
                });
            }
        }
    }
};
