<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Company2DataSeeder extends Seeder
{
    private $companyId = 2;
    private $userId = 1;

    public function run(): void
    {
        echo "🌱 Iniciando seed para Empresa 2...\n\n";

        $this->seedBasicData();
        $cattleIds = $this->seedCattle();
        $this->seedMilkProduction($cattleIds);
        $this->seedVeterinaryServices($cattleIds);
        $this->seedEstates();
        $this->seedWorkmen();
        $this->seedInputs();
        $this->seedDeaths($cattleIds);
        $this->seedSales($cattleIds);

        echo "\n✅ Seed completado exitosamente para Empresa 2!\n";
    }

    private function seedBasicData()
    {
        echo "📋 Creando datos básicos...\n";

        // Categorías
        $categories = ['Toro', 'Vaca', 'Novillo', 'Novilla', 'Ternero', 'Ternera'];
        foreach ($categories as $cat) {
            if (!DB::table('categorys')->where('name', $cat)->where('company_id', $this->companyId)->exists()) {
                DB::table('categorys')->insert([
                    'user_id' => $this->userId,
                    'company_id' => $this->companyId,
                    'name' => $cat,
                ]);
            }
        }

        // Colores
        $colors = ['Negro', 'Blanco', 'Marrón', 'Pinto', 'Rojo'];
        foreach ($colors as $color) {
            if (!DB::table('colors')->where('name', $color)->where('company_id', $this->companyId)->exists()) {
                DB::table('colors')->insert([
                    'user_id' => $this->userId,
                    'company_id' => $this->companyId,
                    'name' => $color,
                ]);
            }
        }

        // Clasificaciones
        $classifications = ['Puro', 'Cruzado', 'Mestizo', 'Enfermo'];
        foreach ($classifications as $class) {
            if (!DB::table('classifications')->where('name', $class)->where('company_id', $this->companyId)->exists()) {
                DB::table('classifications')->insert([
                    'user_id' => $this->userId,
                    'company_id' => $this->companyId,
                    'name' => $class,
                ]);
            }
        }

        // Causas de entrada
        $causes = ['Compra', 'Nacimiento', 'Donación', 'Traspaso'];
        foreach ($causes as $cause) {
            if (!DB::table('cause_entrys')->where('name', $cause)->where('company_id', $this->companyId)->exists()) {
                DB::table('cause_entrys')->insert([
                    'user_id' => $this->userId,
                    'company_id' => $this->companyId,
                    'name' => $cause,
                ]);
            }
        }

        // Estados reproductivos
        $repro = ['Preñada', 'Vacía', 'Servida', 'Seca'];
        foreach ($repro as $r) {
            if (!DB::table('status_reproductives')->where('name', $r)->where('company_id', $this->companyId)->exists()) {
                DB::table('status_reproductives')->insert([
                    'user_id' => $this->userId,
                    'company_id' => $this->companyId,
                    'name' => $r,
                ]);
            }
        }

        // Estados productivos
        $prod = ['En producción', 'Seca', 'Inicio lactancia'];
        foreach ($prod as $p) {
            if (!DB::table('status_productives')->where('name', $p)->where('company_id', $this->companyId)->exists()) {
                DB::table('status_productives')->insert([
                    'user_id' => $this->userId,
                    'company_id' => $this->companyId,
                    'name' => $p,
                ]);
            }
        }

        // Rebaños
        for ($i = 1; $i <= 3; $i++) {
            if (!DB::table('herds')->where('code', "REB$i-E2")->where('company_id', $this->companyId)->exists()) {
                DB::table('herds')->insert([
                    'user_id' => $this->userId,
                    'company_id' => $this->companyId,
                    'code' => "REB$i-E2",
                    'name' => "Rebaño $i - Empresa 2",
                ]);
            }
        }

        // Propietarios
        $owners = ['Juan Pérez', 'María García', 'Carlos López'];
        foreach ($owners as $owner) {
            if (!DB::table('owners')->where('name', $owner)->where('company_id', $this->companyId)->exists()) {
                DB::table('owners')->insert([
                    'user_id' => $this->userId,
                    'company_id' => $this->companyId,
                    'name' => $owner,
                ]);
            }
        }

        echo "✓ Datos básicos creados\n";
    }

    private function seedCattle()
    {
        echo "🐄 Creando animales...\n";

        // Obtener IDs reales de la BD
        $categories = DB::table('categorys')->where('company_id', $this->companyId)->pluck('id', 'name');
        $colors = DB::table('colors')->where('company_id', $this->companyId)->pluck('id', 'name');
        $classifications = DB::table('classifications')->where('company_id', $this->companyId)->pluck('id', 'name');
        $herds = DB::table('herds')->where('company_id', $this->companyId)->pluck('id', 'code');
        $causes = DB::table('cause_entrys')->where('company_id', $this->companyId)->pluck('id', 'name');
        $reproductives = DB::table('status_reproductives')->where('company_id', $this->companyId)->pluck('id', 'name');
        $productives = DB::table('status_productives')->where('company_id', $this->companyId)->pluck('id', 'name');

        $cattles = [
            // 5 Vacas productoras
            ['code' => 'V001', 'sexo' => 'Hembra', 'category' => 'Vaca', 'status_id' => 1, 'herd' => 'REB1-E2', 'date_birth' => '2020-01-15', 'income_weight' => 450, 'price_purchase' => 1500],
            ['code' => 'V002', 'sexo' => 'Hembra', 'category' => 'Vaca', 'status_id' => 1, 'herd' => 'REB1-E2', 'date_birth' => '2020-03-20', 'income_weight' => 460, 'price_purchase' => 1600],
            ['code' => 'V003', 'sexo' => 'Hembra', 'category' => 'Vaca', 'status_id' => 1, 'herd' => 'REB1-E2', 'date_birth' => '2019-11-10', 'income_weight' => 470, 'price_purchase' => 1700],
            ['code' => 'V004', 'sexo' => 'Hembra', 'category' => 'Vaca', 'status_id' => 1, 'herd' => 'REB2-E2', 'date_birth' => '2020-05-05', 'income_weight' => 440, 'price_purchase' => 1400],
            ['code' => 'V005', 'sexo' => 'Hembra', 'category' => 'Vaca', 'status_id' => 1, 'herd' => 'REB2-E2', 'date_birth' => '2020-07-12', 'income_weight' => 455, 'price_purchase' => 1550],
            // 2 Toros
            ['code' => 'T001', 'sexo' => 'Macho', 'category' => 'Toro', 'status_id' => 1, 'herd' => 'REB1-E2', 'date_birth' => '2019-03-10', 'income_weight' => 600, 'price_purchase' => 2500],
            ['code' => 'T002', 'sexo' => 'Macho', 'category' => 'Toro', 'status_id' => 1, 'herd' => 'REB2-E2', 'date_birth' => '2019-05-20', 'income_weight' => 620, 'price_purchase' => 2600],
            // 2 Novillos/Novillas
            ['code' => 'N001', 'sexo' => 'Macho', 'category' => 'Novillo', 'status_id' => 1, 'herd' => 'REB3-E2', 'date_birth' => '2022-01-15', 'income_weight' => 280, 'price_purchase' => 800],
            ['code' => 'NV001', 'sexo' => 'Hembra', 'category' => 'Novilla', 'status_id' => 1, 'herd' => 'REB3-E2', 'date_birth' => '2022-02-10', 'income_weight' => 270, 'price_purchase' => 750],
            // 2 Terneros
            ['code' => 'TR001', 'sexo' => 'Macho', 'category' => 'Ternero', 'status_id' => 1, 'herd' => 'REB3-E2', 'date_birth' => '2024-01-10', 'income_weight' => 40, 'price_purchase' => 0],
            ['code' => 'TRA001', 'sexo' => 'Hembra', 'category' => 'Ternera', 'status_id' => 1, 'herd' => 'REB3-E2', 'date_birth' => '2024-03-05', 'income_weight' => 38, 'price_purchase' => 0],
            // 2 Vendidos
            ['code' => 'VS001', 'sexo' => 'Macho', 'category' => 'Novillo', 'status_id' => 4, 'herd' => 'REB1-E2', 'date_birth' => '2021-06-10', 'income_weight' => 350, 'price_purchase' => 900],
            ['code' => 'VS002', 'sexo' => 'Macho', 'category' => 'Novillo', 'status_id' => 4, 'herd' => 'REB2-E2', 'date_birth' => '2021-07-15', 'income_weight' => 360, 'price_purchase' => 950],
            // 1 Muerto
            ['code' => 'M001', 'sexo' => 'Hembra', 'category' => 'Vaca', 'status_id' => 2, 'herd' => 'REB1-E2', 'date_birth' => '2018-05-10', 'income_weight' => 450, 'price_purchase' => 1500],
        ];

        $cattleIds = [];
        foreach ($cattles as $cattle) {
            $colorKeys = $colors->keys()->toArray();
            $classKeys = $classifications->keys()->toArray();
            
            $id = DB::table('cattles')->insertGetId([
                'user_id' => $this->userId,
                'company_id' => $this->companyId,
                'code' => $cattle['code'],
                'sexo' => $cattle['sexo'],
                'category_id' => $categories[$cattle['category']],
                'status_id' => $cattle['status_id'],
                'herd_id' => $herds[$cattle['herd']],
                'color_id' => $colors[$colorKeys[array_rand($colorKeys)]],
                'classification_id' => $classifications[$classKeys[array_rand($classKeys)]],
                'cause_entry_id' => $cattle['price_purchase'] > 0 ? $causes['Compra'] : $causes['Nacimiento'],
                'status_reproductive_id' => $cattle['sexo'] == 'Hembra' ? $reproductives['Vacía'] : null,
                'status_productive_id' => ($cattle['sexo'] == 'Hembra' && $cattle['category'] == 'Vaca') ? $productives['En producción'] : null,
                'date_birth' => $cattle['date_birth'],
                'date_start' => $cattle['date_birth'],
                'date_revision' => Carbon::parse($cattle['date_birth'])->addMonths(6)->format('Y-m-d'),
                'income_weight' => $cattle['income_weight'],
                'price_purchase' => $cattle['price_purchase'],
            ]);
            $cattleIds[$cattle['code']] = $id;
        }

        echo "✓ " . count($cattles) . " animales creados\n";
        return $cattleIds;
    }

    private function seedMilkProduction($cattleIds)
    {
        echo "🥛 Creando producción de leche...\n";

        $vacas = ['V001', 'V002', 'V003', 'V004', 'V005'];
        $count = 0;

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            foreach ($vacas as $vaca) {
                $liters = rand(15, 30) + (rand(0, 99) / 100);
                $pricePerLiter = 2.50;

                DB::table('milk_production')->insert([
                    'user_id' => $this->userId,
                    'company_id' => $this->companyId,
                    'cattle_id' => $cattleIds[$vaca],
                    'production_date' => $date,
                    'liters' => $liters,
                    'price_per_liter' => $pricePerLiter,
                    'total_price' => $liters * $pricePerLiter,
                    'observations' => 'Producción normal',
                ]);
                $count++;
            }
        }

        echo "✓ $count registros de producción creados\n";
    }

    private function seedVeterinaryServices($cattleIds)
    {
        echo "💉 Creando servicios veterinarios...\n";

        // Productos veterinarios
        $products = [
            ['name' => 'Ivermectina', 'type' => 'Antiparasitario'],
            ['name' => 'Vitamina ADE', 'type' => 'Vitamina'],
            ['name' => 'Antibiótico', 'type' => 'Medicamento'],
            ['name' => 'Vacuna Triple', 'type' => 'Vacuna'],
        ];
        $prodIds = [];
        foreach ($products as $prod) {
            if (!DB::table('products')->where('name', $prod['name'])->where('company_id', $this->companyId)->exists()) {
                $prodIds[] = DB::table('products')->insertGetId([
                    'user_id' => $this->userId,
                    'company_id' => $this->companyId,
                    'name' => $prod['name'],
                    'type' => $prod['type'],
                ]);
            } else {
                $prodIds[] = DB::table('products')->where('name', $prod['name'])->where('company_id', $this->companyId)->value('id');
            }
        }

        // Servicios veterinarios (usando la tabla veterinarians que es la relación)
        $services = [
            ['cattle' => 'V001', 'symptoms' => 'Desparasitación necesaria'],
            ['cattle' => 'V002', 'symptoms' => 'Deficiencia vitamínica'],
            ['cattle' => 'T001', 'symptoms' => 'Vacunación anual'],
            ['cattle' => 'V003', 'symptoms' => 'Infección leve'],
        ];

        foreach ($services as $service) {
            DB::table('veterinarians')->insert([
                'user_id' => $this->userId,
                'company_id' => $this->companyId,
                'cattle_id' => $cattleIds[$service['cattle']],
                'product_id' => $prodIds[array_rand($prodIds)],
                'symptoms' => $service['symptoms'],
                'date_start' => Carbon::now()->subDays(rand(1, 30))->format('Y-m-d'),
                'date_end' => Carbon::now()->subDays(rand(1, 15))->format('Y-m-d'),
                'observation' => 'Control rutinario',
            ]);
        }

        echo "✓ Servicios veterinarios creados\n";
    }

    private function seedEstates()
    {
        echo "🚜 Creando bienes...\n";

        $estates = [
            ['description' => 'Tractor John Deere', 'price' => 25000, 'date_purchase' => '2024-01-15'],
            ['description' => 'Ordeñadora automática', 'price' => 8000, 'date_purchase' => '2024-02-20'],
            ['description' => 'Tanque enfriamiento', 'price' => 3500, 'date_purchase' => '2024-03-10'],
            ['description' => 'Cerca eléctrica', 'price' => 1200, 'date_purchase' => '2024-09-05'],
        ];

        foreach ($estates as $estate) {
            DB::table('estates')->insert([
                'user_id' => $this->userId,
                'company_id' => $this->companyId,
                'description' => $estate['description'],
                'price' => $estate['price'],
                'date_purchase' => $estate['date_purchase'],
            ]);
        }

        echo "✓ " . count($estates) . " bienes creados\n";
    }

    private function seedWorkmen()
    {
        echo "👷 Creando hechuras...\n";

        $workmen = [
            ['description' => 'Ordeño y limpieza - Pedro Ramírez', 'cost' => 800],
            ['description' => 'Alimentación - Luis Fernández', 'cost' => 750],
            ['description' => 'Mantenimiento - José González', 'cost' => 600],
        ];

        foreach ($workmen as $workman) {
            // Mes actual
            DB::table('workmans')->insert([
                'user_id' => $this->userId,
                'company_id' => $this->companyId,
                'description' => $workman['description'],
                'cost' => $workman['cost'],
                'date' => Carbon::now()->startOfMonth()->format('Y-m-d'),
            ]);
            // Mes anterior
            DB::table('workmans')->insert([
                'user_id' => $this->userId,
                'company_id' => $this->companyId,
                'description' => $workman['description'],
                'cost' => $workman['cost'],
                'date' => Carbon::now()->subMonth()->startOfMonth()->format('Y-m-d'),
            ]);
        }

        echo "✓ Hechuras creadas\n";
    }

    private function seedInputs()
    {
        echo "🌾 Creando insumos...\n";

        $inputs = [
            ['description' => 'Alimento balanceado', 'quantity' => 500, 'price' => 2500],
            ['description' => 'Sal mineralizada', 'quantity' => 100, 'price' => 300],
            ['description' => 'Heno', 'quantity' => 200, 'price' => 800],
            ['description' => 'Melaza', 'quantity' => 150, 'price' => 450],
        ];

        $ownerIds = DB::table('owners')->where('company_id', $this->companyId)->pluck('id')->toArray();
        
        foreach ($inputs as $input) {
            DB::table('inputs')->insert([
                'user_id' => $this->userId,
                'company_id' => $this->companyId,
                'owner_id' => $ownerIds[array_rand($ownerIds)],
                'description' => $input['description'],
                'quantity' => $input['quantity'],
                'price' => $input['price'],
                'date' => Carbon::now()->subDays(rand(1, 30))->format('Y-m-d'),
            ]);
        }

        echo "✓ " . count($inputs) . " insumos creados\n";
    }

    private function seedDeaths($cattleIds)
    {
        echo "💀 Creando registro de muerte...\n";

        DB::table('deaths')->insert([
            'user_id' => $this->userId,
            'company_id' => $this->companyId,
            'cattle_id' => $cattleIds['M001'],
            'date' => '2024-09-15',
            'reason' => 'Enfermedad - Muerte natural por edad avanzada',
        ]);

        echo "✓ Muerte registrada\n";
    }

    private function seedSales($cattleIds)
    {
        echo "💰 Creando ventas...\n";

        $sales = [
            ['cattle' => 'VS001', 'sale_price' => 1800, 'sale_date' => '2024-08-10'],
            ['cattle' => 'VS002', 'sale_price' => 1900, 'sale_date' => '2024-08-25'],
        ];

        foreach ($sales as $sale) {
            DB::table('sales')->insert([
                'user_id' => $this->userId,
                'company_id' => $this->companyId,
                'cattle_id' => $cattleIds[$sale['cattle']],
                'sale_date' => $sale['sale_date'],
                'sale_price' => $sale['sale_price'],
                'observations' => 'Venta exitosa',
            ]);
        }

        echo "✓ " . count($sales) . " ventas creadas\n";
    }
}
