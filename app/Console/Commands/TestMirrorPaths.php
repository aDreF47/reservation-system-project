<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TestMirrorPaths extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'test:mirror-paths';

    /**
     * The console command description.
     */
    protected $description = 'Probar dónde se guardan los archivos de mirror';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Diagnóstico de rutas de Mirror');
        
        // 1. Mostrar rutas
        $this->info('📁 Rutas del sistema:');
        $this->line('Base path: ' . base_path());
        $this->line('Storage path: ' . storage_path());
        $this->line('Storage app path: ' . storage_path('app'));
        $this->line('Storage disk path: ' . Storage::path(''));
        
        // 2. Crear directorios
        $this->info('📂 Creando directorios...');
        $mirrorDir = storage_path('app/mirrors');
        $indexDir = storage_path('app/mirrors/indexes');
        
        if (!file_exists($mirrorDir)) {
            mkdir($mirrorDir, 0755, true);
            $this->info("✅ Creado: {$mirrorDir}");
        } else {
            $this->info("✅ Ya existe: {$mirrorDir}");
        }
        
        if (!file_exists($indexDir)) {
            mkdir($indexDir, 0755, true);
            $this->info("✅ Creado: {$indexDir}");
        } else {
            $this->info("✅ Ya existe: {$indexDir}");
        }
        
        // 3. Probar escritura
        $this->info('✍️ Probando escritura de archivos...');
        
        $testContent = "# TEST FILE\n# Created at: " . now() . "\nTest content for mirror system.";
        
        // Probar con Storage facade
        try {
            Storage::put('mirrors/test_storage.txt', $testContent);
            $this->info('✅ Storage::put() funciona');
            $this->line('Archivo: ' . storage_path('app/mirrors/test_storage.txt'));
        } catch (\Exception $e) {
            $this->error('❌ Storage::put() falló: ' . $e->getMessage());
        }
        
        // Probar con file_put_contents
        try {
            $testPath = storage_path('app/mirrors/test_direct.txt');
            file_put_contents($testPath, $testContent);
            $this->info('✅ file_put_contents() funciona');
            $this->line('Archivo: ' . $testPath);
        } catch (\Exception $e) {
            $this->error('❌ file_put_contents() falló: ' . $e->getMessage());
        }
        
        // 4. Listar archivos existentes
        $this->info('📋 Archivos existentes en mirrors:');
        $files = Storage::files('mirrors');
        if (empty($files)) {
            $this->warn('No hay archivos en storage/app/mirrors/');
        } else {
            foreach ($files as $file) {
                $this->line("- {$file}");
            }
        }
        
        // 5. Verificar permisos
        $this->info('🔐 Verificando permisos...');
        $this->line('Permisos de storage/app: ' . substr(sprintf('%o', fileperms(storage_path('app'))), -4));
        if (file_exists($mirrorDir)) {
            $this->line('Permisos de mirrors: ' . substr(sprintf('%o', fileperms($mirrorDir)), -4));
        }
        
        $this->info('🎯 Diagnóstico completado. Ejecuta: php artisan db:mirror para generar archivos reales.');
        
        return 0;
    }
}