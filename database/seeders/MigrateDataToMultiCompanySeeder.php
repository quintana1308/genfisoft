<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class MigrateDataToMultiCompanySeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Migrar datos existentes asignando company_id basado en user_id
        $users = User::with('company')->get();
        
        foreach ($users as $user) {
            if ($user->company_id) {
                $companyId = $user->company_id;
                
                // Actualizar todas las tablas de datos del usuario
                $tables = [
                    'cattles',
                    'categories', 
                    'herds',
                    'owners',
                    'products',
                    'veterinarians',
                    'workmen',
                    'deaths',
                    'estates',
                    'inputs',
                    'cause_entries',
                    'colors',
                    'classifications',
                    'status_productives',
                    'status_reproductives'
                ];
                
                foreach ($tables as $table) {
                    // Verificar si la tabla existe y tiene la columna user_id
                    if (DB::getSchemaBuilder()->hasTable($table) && 
                        DB::getSchemaBuilder()->hasColumn($table, 'user_id')) {
                        
                        DB::table($table)
                            ->where('user_id', $user->id)
                            ->whereNull('company_id')
                            ->update(['company_id' => $companyId]);
                    }
                }
                
                $this->command->info("Datos migrados para usuario: {$user->name} -> Empresa ID: {$companyId}");
            }
        }
        
        $this->command->info('Migración de datos a sistema multi-empresa completada');
    }
}
