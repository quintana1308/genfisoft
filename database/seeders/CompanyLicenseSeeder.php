<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\License;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompanyLicenseSeeder extends Seeder
{
    public function run()
    {
        // Crear empresa de ejemplo
        $company = Company::create([
            'name' => 'Finca Demo',
            'business_name' => 'Finca Demostrativa C.A.',
            'tax_id' => 'J-12345678-9',
            'email' => 'admin@fincademo.com',
            'phone' => '+58-414-1234567',
            'address' => 'Carretera Nacional, Sector El Rodeo',
            'city' => 'Maracay',
            'state' => 'Aragua',
            'country' => 'Venezuela',
            'settings' => [
                'currency' => 'USD',
                'timezone' => 'America/Caracas',
                'language' => 'es'
            ],
            'status_id' => 1
        ]);

        // Crear licencia activa para la empresa
        $license = License::create([
            'company_id' => $company->id,
            'license_key' => License::generateLicenseKey(),
            'plan_type' => 'premium',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYear()->toDateString(),
            'max_users' => 10,
            'max_cattle' => 1000,
            'features' => ['basic_reports', 'cattle_management', 'veterinary', 'financial'],
            'status' => 'active',
            'price' => 299.99,
            'payment_reference' => 'DEMO-2024-001',
            'notes' => 'Licencia de demostración'
        ]);

        // Crear usuario administrador
        $adminUser = User::create([
            'company_id' => $company->id,
            'name' => 'Administrador Demo',
            'rebaño' => 'Rebaño Principal',
            'email' => 'admin@fincademo.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now()
        ]);

        // Crear usuario operador
        $operatorUser = User::create([
            'company_id' => $company->id,
            'name' => 'Operador Demo',
            'rebaño' => 'Rebaño Secundario',
            'email' => 'operador@fincademo.com',
            'password' => Hash::make('password123'),
            'role' => 'operator',
            'is_active' => true,
            'email_verified_at' => now()
        ]);

        $this->command->info('Empresa demo creada con licencia activa');
        $this->command->info('Usuario Admin: admin@fincademo.com / password123');
        $this->command->info('Usuario Operador: operador@fincademo.com / password123');
        $this->command->info('Licencia válida hasta: ' . $license->end_date->format('d/m/Y'));
    }
}
