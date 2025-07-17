<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DatabaseMirrorService;
use Illuminate\Support\Facades\Storage;

class MirrorController extends Controller
{
    private $mirrorService;

    public function __construct()
    {
        $this->mirrorService = new DatabaseMirrorService();
    }

    /**
     * Mostrar panel de gestión de mirrors
     */
    public function index()
    {
        $mirrors = $this->getAvailableMirrors();
        $stats = $this->getMirrorStats();
        
        return view('admin.mirrors.index', compact('mirrors', 'stats'));
    }

    /**
     * Generar nuevo mirror vía AJAX
     */
    public function generate(Request $request)
    {
        try {
            $result = $this->mirrorService->generateFullMirror();
            
            return response()->json([
                'success' => true,
                'message' => 'Mirror generado exitosamente',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar mirror: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Buscar en mirror via AJAX
     */
    public function search(Request $request)
    {
        $request->validate([
            'table' => 'required|string',
            'field' => 'required|string', 
            'value' => 'required',
            'timestamp' => 'nullable|string'
        ]);

        try {
            $results = $this->mirrorService->findByIndex(
                $request->table,
                $request->field,
                $request->value,
                $request->timestamp
            );

            return response()->json([
                'success' => true,
                'data' => $results,
                'count' => count($results)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Descargar mirror
     */
    public function download($table, $timestamp)
    {
        $filename = "mirrors/{$table}_mirror_{$timestamp}.txt";
        
        if (!Storage::exists($filename)) {
            abort(404, 'Mirror no encontrado');
        }

        return Storage::download($filename, "{$table}_mirror_{$timestamp}.txt");
    }

    /**
     * Eliminar mirror específico
     */
    public function delete($timestamp)
    {
        try {
            $files = Storage::files('mirrors/');
            $deleted = 0;
            
            foreach ($files as $file) {
                if (strpos($file, $timestamp) !== false) {
                    Storage::delete($file);
                    $deleted++;
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => "Eliminados {$deleted} archivos del mirror {$timestamp}"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Limpiar mirrors antiguos
     */
    public function cleanup(Request $request)
    {
        $keep = $request->input('keep', 5);
        
        try {
            $deleted = $this->mirrorService->cleanOldMirrors($keep);
            
            return response()->json([
                'success' => true,
                'message' => "Eliminados {$deleted} mirrors antiguos. Mantenidos los últimos {$keep}."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener mirrors disponibles
     */
    private function getAvailableMirrors()
    {
        $files = Storage::files('mirrors/');
        $mirrors = [];
        
        foreach ($files as $file) {
            if (strpos($file, 'metadata_') !== false) {
                $content = json_decode(Storage::get($file), true);
                if ($content) {
                    $mirrors[] = $content;
                }
            }
        }
        
        // Ordenar por timestamp descendente
        usort($mirrors, function($a, $b) {
            return strcmp($b['timestamp'], $a['timestamp']);
        });
        
        return $mirrors;
    }

    /**
     * Obtener estadísticas de mirrors
     */
    private function getMirrorStats()
    {
        $files = Storage::files('mirrors/');
        $totalSize = 0;
        $mirrorCount = 0;
        $indexCount = 0;
        
        foreach ($files as $file) {
            $size = Storage::size($file);
            $totalSize += $size;
            
            if (strpos($file, '_mirror_') !== false) {
                $mirrorCount++;
            } elseif (strpos($file, '_index_') !== false) {
                $indexCount++;
            }
        }
        
        return [
            'total_files' => count($files),
            'mirror_files' => $mirrorCount,
            'index_files' => $indexCount,
            'total_size' => $totalSize,
            'total_size_human' => $this->formatBytes($totalSize),
            'last_update' => $this->getLastUpdateTime()
        ];
    }

    /**
     * Formatear bytes a formato legible
     */
    private function formatBytes($size, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }

    /**
     * Obtener última fecha de actualización
     */
    private function getLastUpdateTime()
    {
        $files = Storage::files('mirrors/');
        $lastModified = 0;
        
        foreach ($files as $file) {
            $modified = Storage::lastModified($file);
            if ($modified > $lastModified) {
                $lastModified = $modified;
            }
        }
        
        return $lastModified ? date('Y-m-d H:i:s', $lastModified) : null;
    }
}

