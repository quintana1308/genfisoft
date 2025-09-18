<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// Importa el comando
use App\Console\Commands\EnviarMensajesProgramados;

class Kernel extends ConsoleKernel
{
    /**
     * Registrar los comandos de Artisan para tu aplicación.
     */
    protected function commands()
    {
        // Registrar comandos aquí si es necesario
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Definir la programación de comandos (cron jobs).
     */
    protected function schedule(Schedule $schedule)
    {
        // Aquí puedes programar si deseas que se ejecute automáticamente
        // $schedule->command('mensajes:enviar')->hourly();
    }

    /**
     * Los comandos Artisan disponibles para tu aplicación.
     */
    protected $commands = [
        EnviarMensajesProgramados::class,
    ];
}
