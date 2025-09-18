<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class UserCompanySeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Migrar usuarios existentes a la tabla pivot
        $users = User::with('company')->get();
        
        foreach ($users as $user) {
            if ($user->company_id) {
                // Crear relación en tabla pivot
                DB::table('user_companies')->insertOrIgnore([
                    'user_id' => $user->id,
                    'company_id' => $user->company_id,
                    'is_primary' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // Establecer empresa activa
                $user->update(['active_company_id' => $user->company_id]);
            }
        }
        
        $this->command->info('Usuarios migrados a sistema multi-empresa');
    }
}
