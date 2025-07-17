<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DatabaseMirrorService;

class GenerateDatabaseMirror extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'db:mirror 
                          {--tables=* : Específicas tablas a incluir}
                          {--clean=5 : Número de mirrors a mantener}
                          {--format=txt : Formato de salida (txt|json)}';

    /**
     * The console command description.
     */
    protected $description = 'Generar mirror indexado de la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Iniciando generación de mirror de base de datos...');
        
        $mirrorService = new DatabaseMirrorService();
        
        try {
            // Limpiar mirrors antiguos si se especifica
            $cleanCount = (int) $this->option('clean');
            if ($cleanCount > 0) {
                $this->info('🧹 Limpiando mirrors antiguos...');
                $deleted = $mirrorService->cleanOldMirrors($cleanCount);
                $this->info("✅ Eliminados {$deleted} mirrors antiguos");
            }

            // Generar nuevo mirror
            $this->info('📊 Generando mirror...');
            $this->withProgressBar(['hotels', 'room_types', 'rooms', 'reservations', 'users', 'payments', 'reviews'], function ($table) use ($mirrorService) {
                // Simulación de progreso por tabla
                sleep(1);
            });
            
            $result = $mirrorService->generateFullMirror();
            
            $this->newLine(2);
            $this->info('✅ Mirror generado exitosamente!');
            $this->table(
                ['Métrica', 'Valor'],
                [
                    ['Timestamp', $result['timestamp']],
                    ['Tablas procesadas', $result['tables_processed']],
                    ['Total registros', number_format($result['total_records'])],
                    ['Estado', $result['status']]
                ]
            );

            // Mostrar ejemplo de uso
            $this->newLine();
            $this->comment('📖 Ejemplo de uso del mirror:');
            $this->line('$service = new DatabaseMirrorService();');
            $this->line('$hotels = $service->findByIndex("hotels", "city", "Lima");');
            $this->line('$user = $service->findByIndex("users", "id", 123);');

        } catch (\Exception $e) {
            $this->error('❌ Error al generar mirror: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}