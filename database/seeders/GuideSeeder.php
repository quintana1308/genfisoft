<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guide;
use App\Models\User;
use App\Models\Company;

class GuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el primer usuario y empresa para los datos de ejemplo
        $user = User::first();
        $company = Company::first();

        if (!$user || !$company) {
            $this->command->warn('No se encontraron usuarios o empresas. Ejecuta primero CompanyLicenseSeeder.');
            return;
        }

        $guides = [
            'Guía de Manejo',
            'Guía Sanitaria',
            'Guía de Alimentación',
            'Guía de Reproducción',
            'Guía de Registro',
            'Guía de Bioseguridad',
            'Guía de Transporte',
            'Guía de Bienestar Animal',
        ];

        foreach ($guides as $guideName) {
            Guide::create([
                'name' => $guideName,
                'user_id' => $user->id,
                'company_id' => $company->id,
                'status_id' => 1 // Activo
            ]);
        }

        $this->command->info('Guías de ejemplo creadas correctamente.');
    }
}
