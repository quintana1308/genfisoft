<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('company_id')->after('id')->constrained('companies')->onDelete('cascade');
            $table->enum('role', ['admin', 'manager', 'operator', 'viewer'])->after('company_id')->default('operator');
            $table->boolean('is_active')->after('role')->default(true);
            $table->timestamp('last_login_at')->nullable()->after('is_active');
            
            $table->index(['company_id', 'is_active']);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn(['company_id', 'role', 'is_active', 'last_login_at']);
        });
    }
};
