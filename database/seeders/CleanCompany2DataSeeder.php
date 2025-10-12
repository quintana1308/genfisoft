<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CleanCompany2DataSeeder extends Seeder
{
    private $companyId = 2;
    private $userId = 1;

    public function run()
    {
        echo "🧹 Limpiando datos de Empresa 2...\n";

        // Obtener IDs de animales de la empresa 2 antes de eliminarlos
        $cattleIds = DB::table('cattles')->where('company_id', $this->companyId)->pluck('id')->toArray();

        // Eliminar en orden inverso para respetar las relaciones
        
        // 1. Ventas
        DB::table('sales')->where('company_id', $this->companyId)->delete();
        echo "✓ Ventas eliminadas\n";

        // 2. Muertes
        DB::table('deaths')->where('company_id', $this->companyId)->delete();
        echo "✓ Muertes eliminadas\n";

        // 3. Insumos
        DB::table('inputs')->where('company_id', $this->companyId)->delete();
        echo "✓ Insumos eliminados\n";

        // 4. Hechuras
        DB::table('workmans')->where('company_id', $this->companyId)->delete();
        echo "✓ Hechuras eliminadas\n";

        // 5. Bienes
        DB::table('estates')->where('company_id', $this->companyId)->delete();
        echo "✓ Bienes eliminados\n";

        // 6. Servicios veterinarios
        DB::table('veterinarians')->where('company_id', $this->companyId)->delete();
        echo "✓ Servicios veterinarios eliminados\n";

        // 7. Productos
        DB::table('products')->where('company_id', $this->companyId)->delete();
        echo "✓ Productos eliminados\n";

        // 8. Producción de leche
        DB::table('milk_production')->where('company_id', $this->companyId)->delete();
        echo "✓ Producción de leche eliminada\n";

        // 9. Animales (cattles)
        DB::table('cattles')->where('company_id', $this->companyId)->delete();
        echo "✓ Animales eliminados\n";

        // 10. Propietarios
        DB::table('owners')->where('company_id', $this->companyId)->delete();
        echo "✓ Propietarios eliminados\n";

        // 11. Rebaños
        DB::table('herds')->where('company_id', $this->companyId)->delete();
        echo "✓ Rebaños eliminados\n";

        // 12. Estados productivos
        DB::table('status_productives')->where('company_id', $this->companyId)->delete();
        echo "✓ Estados productivos eliminados\n";

        // 13. Estados reproductivos
        DB::table('status_reproductives')->where('company_id', $this->companyId)->delete();
        echo "✓ Estados reproductivos eliminados\n";

        // 14. Causas de entrada
        DB::table('cause_entrys')->where('company_id', $this->companyId)->delete();
        echo "✓ Causas de entrada eliminadas\n";

        // 15. Clasificaciones
        DB::table('classifications')->where('company_id', $this->companyId)->delete();
        echo "✓ Clasificaciones eliminadas\n";

        // 16. Colores
        DB::table('colors')->where('company_id', $this->companyId)->delete();
        echo "✓ Colores eliminados\n";

        // 17. Categorías
        DB::table('categorys')->where('company_id', $this->companyId)->delete();
        echo "✓ Categorías eliminadas\n";

        echo "\n✅ Limpieza completada exitosamente para Empresa 2!\n";
        echo "💡 Ahora puedes ejecutar: php artisan db:seed --class=Company2DataSeeder\n";
    }
}
