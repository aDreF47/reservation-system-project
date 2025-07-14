<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Hotel;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Characteristic;
use App\Models\ImgRoomType;
use Carbon\Carbon;

class DatabaseMirrorService
{
    // CAMBIO 1: Usar rutas más simples sin conflictos
    private $mirrorPath = 'mirrors/';
    private $indexPath = 'mirrors/indexes/';
    
    /**
     * Configuración de tablas para el mirror - SIN FUNCIONES ANÓNIMAS
     */
    private $mirrorConfig = [
        'hotels' => [
            'type' => 'complete',
            'conditions' => ['active' => 1],
            'index_fields' => ['id', 'name', 'city']
        ],
        'room_types' => [
            'type' => 'complete',
            'conditions' => [],
            'index_fields' => ['id', 'hotel_id', 'name']
        ],
        'rooms' => [
            'type' => 'complete', 
            'conditions' => ['available' => 1],
            'index_fields' => ['id', 'room_type_id', 'room_number']
        ],
        'reservations' => [
            'type' => 'filtered',
            'conditions' => 'recent', // ← CAMBIADO: string en lugar de función
            'index_fields' => ['id', 'user_id', 'room_id', 'status']
        ],
        'users' => [
            'type' => 'filtered',
            'conditions' => ['role' => 'cliente'],
            'exclude_fields' => ['password', 'remember_token'],
            'index_fields' => ['id', 'email', 'name']
        ],
        'payments' => [
            'type' => 'aggregated',
            'conditions' => 'recent_months', // ← CAMBIADO: string en lugar de función
            'index_fields' => ['id', 'reservation_id', 'status']
        ],
        'reviews' => [
            'type' => 'filtered',
            'conditions' => ['approved' => 1],
            'index_fields' => ['id', 'hotel_id', 'user_id', 'rating']
        ]
    ];

    /**
     * Generar mirror completo de la base de datos
     */
    public function generateFullMirror()
    {
        $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
        $mirrorData = [];
        $indexData = [];

        foreach ($this->mirrorConfig as $table => $config) {
            echo "Procesando tabla: {$table}\n";
            
            $data = $this->extractTableData($table, $config);
            $index = $this->generateTableIndex($table, $data, $config['index_fields']);
            
            $mirrorData[$table] = $data;
            $indexData[$table] = $index;
            
            // Guardar archivo individual por tabla
            $this->saveTableMirror($table, $data, $timestamp);
            $this->saveTableIndex($table, $index, $timestamp);
        }

        // Guardar mirror completo
        $this->saveCompleteMirror($mirrorData, $timestamp);
        $this->saveCompleteIndex($indexData, $timestamp);
        
        // Generar metadatos
        $this->saveMetadata($timestamp, $mirrorData);

        return [
            'status' => 'success',
            'timestamp' => $timestamp,
            'tables_processed' => count($this->mirrorConfig),
            'total_records' => array_sum(array_map('count', $mirrorData))
        ];
    }

    /**
     * Extraer datos de una tabla específica - MÉTODO CORREGIDO
     */
    private function extractTableData($table, $config)
    {
        $query = DB::table($table);

        // Aplicar condiciones - LÓGICA CORREGIDA
        if (!empty($config['conditions'])) {
            if (is_string($config['conditions'])) {
                // Manejar condiciones especiales con strings
                switch ($config['conditions']) {
                    case 'recent':
                        $query->where('check_out', '>=', Carbon::now()->subMonths(3));
                        break;
                    case 'recent_months':
                        $query->where('created_at', '>=', Carbon::now()->subMonths(6));
                        break;
                }
            } elseif (is_array($config['conditions'])) {
                // Manejar condiciones normales de array
                foreach ($config['conditions'] as $field => $value) {
                    $query->where($field, $value);
                }
            }
        }

        // Excluir campos si es necesario
        if (!empty($config['exclude_fields'])) {
            $allColumns = DB::getSchemaBuilder()->getColumnListing($table);
            $selectColumns = array_diff($allColumns, $config['exclude_fields']);
            $query->select($selectColumns);
        }

        // Procesar según el tipo
        switch ($config['type']) {
            case 'complete':
                return $query->get()->toArray();
                
            case 'filtered':
                return $query->orderBy('created_at', 'desc')->get()->toArray();
                
            case 'aggregated':
                if ($table === 'payments') {
                    return $this->getAggregatedPayments($query);
                }
                return $query->get()->toArray();
                
            default:
                return $query->get()->toArray();
        }
    }

    /**
     * Obtener datos agregados de pagos
     */
    private function getAggregatedPayments($query)
    {
        $rawData = $query->get()->toArray();
        $aggregated = [];

        // Agregar por mes y estado
        foreach ($rawData as $payment) {
            $month = Carbon::parse($payment->created_at)->format('Y-m');
            $key = $month . '_' . $payment->status;
            
            if (!isset($aggregated[$key])) {
                $aggregated[$key] = [
                    'month' => $month,
                    'status' => $payment->status,
                    'count' => 0,
                    'total_amount' => 0,
                    'avg_amount' => 0
                ];
            }
            
            $aggregated[$key]['count']++;
            $aggregated[$key]['total_amount'] += $payment->amount;
            $aggregated[$key]['avg_amount'] = $aggregated[$key]['total_amount'] / $aggregated[$key]['count'];
        }

        return array_values($aggregated);
    }

    /**
     * Generar índice para acceso directo
     */
    private function generateTableIndex($table, $data, $indexFields)
    {
        $index = [];
        
        foreach ($data as $position => $record) {
            $record = (array) $record;
            
            foreach ($indexFields as $field) {
                if (isset($record[$field])) {
                    $value = $record[$field];
                    
                    if (!isset($index[$field])) {
                        $index[$field] = [];
                    }
                    
                    if (!isset($index[$field][$value])) {
                        $index[$field][$value] = [];
                    }
                    
                    $index[$field][$value][] = $position;
                }
            }
        }

        return $index;
    }

    /**
     * CAMBIO 2: Guardar mirror de tabla individual - MÉTODO CORREGIDO
     */
    private function saveTableMirror($table, $data, $timestamp)
    {
        // Crear directorios con rutas absolutas
        $mirrorDir = storage_path('app/mirrors');
        if (!file_exists($mirrorDir)) {
            mkdir($mirrorDir, 0755, true);
            echo "✅ Directorio creado: {$mirrorDir}\n";
        }
        
        // Usar file_put_contents directamente para evitar problemas de Storage
        $filename = "{$table}_mirror_{$timestamp}.txt";
        $absolutePath = $mirrorDir . DIRECTORY_SEPARATOR . $filename;
        
        $content = "# MIRROR TABLE: {$table}\n";
        $content .= "# TIMESTAMP: {$timestamp}\n";
        $content .= "# RECORDS: " . count($data) . "\n";
        $content .= "# FILE PATH: {$absolutePath}\n";
        $content .= "# ================================================\n\n";
        
        foreach ($data as $position => $record) {
            $content .= "RECORD_POS:{$position}|" . $this->serializeRecord($record) . "\n";
        }

        // Guardar directamente con file_put_contents
        $bytesWritten = file_put_contents($absolutePath, $content);
        
        if ($bytesWritten !== false) {
            echo "✅ Mirror guardado: {$absolutePath} ({$bytesWritten} bytes)\n";
        } else {
            echo "❌ ERROR: No se pudo guardar {$absolutePath}\n";
        }
    }

    /**
     * CAMBIO 3: Guardar índice de tabla - MÉTODO CORREGIDO
     */
    private function saveTableIndex($table, $index, $timestamp)
    {
        // Crear directorios con rutas absolutas
        $indexDir = storage_path('app/mirrors/indexes');
        if (!file_exists($indexDir)) {
            mkdir($indexDir, 0755, true);
            echo "✅ Directorio índices creado: {$indexDir}\n";
        }
        
        $filename = "{$table}_index_{$timestamp}.txt";
        $absolutePath = $indexDir . DIRECTORY_SEPARATOR . $filename;
        
        $content = "# INDEX TABLE: {$table}\n";
        $content .= "# TIMESTAMP: {$timestamp}\n";
        $content .= "# FILE PATH: {$absolutePath}\n";
        $content .= "# ================================================\n\n";
        
        foreach ($index as $field => $values) {
            $content .= "FIELD:{$field}\n";
            foreach ($values as $value => $positions) {
                $content .= "VALUE:{$value}|POSITIONS:" . implode(',', $positions) . "\n";
            }
            $content .= "\n";
        }

        $bytesWritten = file_put_contents($absolutePath, $content);
        
        if ($bytesWritten !== false) {
            echo "✅ Índice guardado: {$absolutePath} ({$bytesWritten} bytes)\n";
        } else {
            echo "❌ ERROR: No se pudo guardar índice {$absolutePath}\n";
        }
    }

    /**
     * CAMBIO 4: Guardar mirror completo - MÉTODO CORREGIDO
     */
    private function saveCompleteMirror($mirrorData, $timestamp)
    {
        $mirrorDir = storage_path('app/mirrors');
        $filename = "complete_mirror_{$timestamp}.txt";
        $absolutePath = $mirrorDir . DIRECTORY_SEPARATOR . $filename;
        
        $content = "# COMPLETE MIRROR\n";
        $content .= "# TIMESTAMP: {$timestamp}\n";
        $content .= "# TOTAL_TABLES: " . count($mirrorData) . "\n";
        $content .= "# FILE PATH: {$absolutePath}\n";
        $content .= "# ================================================\n\n";
        
        foreach ($mirrorData as $table => $data) {
            $content .= "TABLE:{$table}|RECORDS:" . count($data) . "\n";
        }

        file_put_contents($absolutePath, $content);
        echo "✅ Mirror completo guardado: {$absolutePath}\n";
    }

    /**
     * CAMBIO 5: Guardar índice completo - MÉTODO CORREGIDO
     */
    private function saveCompleteIndex($indexData, $timestamp)
    {
        $indexDir = storage_path('app/mirrors/indexes');
        $filename = "complete_index_{$timestamp}.txt";
        $absolutePath = $indexDir . DIRECTORY_SEPARATOR . $filename;
        
        $content = "# COMPLETE INDEX\n";
        $content .= "# TIMESTAMP: {$timestamp}\n";
        $content .= "# FILE PATH: {$absolutePath}\n";
        $content .= "# ================================================\n\n";
        
        foreach ($indexData as $table => $index) {
            $content .= "TABLE_INDEX:{$table}\n";
            foreach ($index as $field => $values) {
                $content .= "FIELD:{$field}|VALUES:" . count($values) . "\n";
            }
            $content .= "\n";
        }

        file_put_contents($absolutePath, $content);
        echo "✅ Índice completo guardado: {$absolutePath}\n";
    }

    /**
     * Serializar registro para almacenamiento
     */
    private function serializeRecord($record)
    {
        $record = (array) $record;
        $serialized = [];
        
        foreach ($record as $field => $value) {
            $serialized[] = "{$field}:" . base64_encode(json_encode($value));
        }
        
        return implode('|', $serialized);
    }

    /**
     * Deserializar registro desde almacenamiento
     */
    private function deserializeRecord($serializedRecord)
    {
        $parts = explode('|', $serializedRecord);
        $record = [];
        
        foreach ($parts as $part) {
            if (strpos($part, ':') !== false) {
                list($field, $encodedValue) = explode(':', $part, 2);
                $record[$field] = json_decode(base64_decode($encodedValue), true);
            }
        }
        
        return $record;
    }

    /**
     * CAMBIO 6: Buscar registros usando el índice - MÉTODO CORREGIDO
     */
    public function findByIndex($table, $field, $value, $timestamp = null)
    {
        if (!$timestamp) {
            $timestamp = $this->getLatestTimestamp();
        }

        // Cargar índice con ruta absoluta
        $indexFile = storage_path("app/mirrors/indexes/{$table}_index_{$timestamp}.txt");
        if (!file_exists($indexFile)) {
            throw new \Exception("Índice no encontrado para tabla {$table} en {$indexFile}");
        }

        $indexContent = file_get_contents($indexFile);
        $positions = $this->parseIndexForValue($indexContent, $field, $value);

        if (empty($positions)) {
            return [];
        }

        // Cargar datos y obtener registros en las posiciones encontradas
        $mirrorFile = storage_path("app/mirrors/{$table}_mirror_{$timestamp}.txt");
        $mirrorContent = file_get_contents($mirrorFile);
        
        return $this->getRecordsAtPositions($mirrorContent, $positions);
    }

    /**
     * Parsear índice para encontrar posiciones de un valor
     */
    private function parseIndexForValue($indexContent, $field, $value)
    {
        $lines = explode("\n", $indexContent);
        $inField = false;
        
        foreach ($lines as $line) {
            if (strpos($line, "FIELD:{$field}") === 0) {
                $inField = true;
                continue;
            }
            
            if ($inField && strpos($line, "FIELD:") === 0) {
                break; // Salir del campo actual
            }
            
            if ($inField && strpos($line, "VALUE:{$value}|") === 0) {
                $parts = explode('|', $line);
                if (count($parts) >= 2 && strpos($parts[1], 'POSITIONS:') === 0) {
                    $positionsStr = substr($parts[1], 10); // Remover "POSITIONS:"
                    return array_map('intval', explode(',', $positionsStr));
                }
            }
        }
        
        return [];
    }

    /**
     * Obtener registros en posiciones específicas
     */
    private function getRecordsAtPositions($mirrorContent, $positions)
    {
        $lines = explode("\n", $mirrorContent);
        $records = [];
        
        foreach ($lines as $line) {
            if (strpos($line, 'RECORD_POS:') === 0) {
                $parts = explode('|', $line, 2);
                if (count($parts) >= 2) {
                    $posMatch = [];
                    if (preg_match('/RECORD_POS:(\d+)/', $parts[0], $posMatch)) {
                        $position = (int) $posMatch[1];
                        if (in_array($position, $positions)) {
                            $records[] = $this->deserializeRecord($parts[1]);
                        }
                    }
                }
            }
        }
        
        return $records;
    }

    /**
     * CAMBIO 7: Obtener último timestamp disponible - MÉTODO CORREGIDO
     */
    private function getLatestTimestamp()
    {
        $mirrorDir = storage_path('app/mirrors');
        if (!file_exists($mirrorDir)) {
            return null;
        }
        
        $files = glob($mirrorDir . DIRECTORY_SEPARATOR . '*_mirror_*.txt');
        $timestamps = [];
        
        foreach ($files as $file) {
            $basename = basename($file);
            if (preg_match('/mirror_(\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2})\.txt$/', $basename, $matches)) {
                $timestamps[] = $matches[1];
            }
        }
        
        return empty($timestamps) ? null : max($timestamps);
    }

    /**
     * CAMBIO 8: Guardar metadatos del mirror - MÉTODO CORREGIDO
     */
    private function saveMetadata($timestamp, $mirrorData)
    {
        $mirrorDir = storage_path('app/mirrors');
        
        $metadata = [
            'timestamp' => $timestamp,
            'generated_at' => Carbon::now()->toISOString(),
            'storage_path' => $mirrorDir,
            'tables' => [],
            'total_records' => 0,
            'mirror_version' => '1.0',
            'laravel_version' => app()->version(),
            'database' => config('database.default')
        ];

        foreach ($mirrorData as $table => $data) {
            $metadata['tables'][$table] = [
                'record_count' => count($data),
                'indexed_fields' => $this->mirrorConfig[$table]['index_fields'],
                'type' => $this->mirrorConfig[$table]['type'],
                'file_path' => $mirrorDir . DIRECTORY_SEPARATOR . "{$table}_mirror_{$timestamp}.txt"
            ];
            $metadata['total_records'] += count($data);
        }

        $filename = "metadata_{$timestamp}.json";
        $absolutePath = $mirrorDir . DIRECTORY_SEPARATOR . $filename;
        
        file_put_contents($absolutePath, json_encode($metadata, JSON_PRETTY_PRINT));
        
        echo "✅ Metadata guardado: {$absolutePath}\n";
        echo "📊 Total de archivos creados: " . (count($mirrorData) * 2 + 3) . "\n";
        echo "📁 Ubicación: {$mirrorDir}\n";
    }

    /**
     * CAMBIO 9: Limpiar mirrors antiguos - MÉTODO CORREGIDO
     */
    public function cleanOldMirrors($keepLast = 5)
    {
        $mirrorDir = storage_path('app/mirrors');
        if (!file_exists($mirrorDir)) {
            return 0;
        }
        
        $files = glob($mirrorDir . DIRECTORY_SEPARATOR . '*_mirror_*.txt');
        $mirrorFiles = [];
        
        foreach ($files as $file) {
            $basename = basename($file);
            if (preg_match('/mirror_(\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2})\.txt$/', $basename, $matches)) {
                $mirrorFiles[$matches[1]][] = $file;
            }
        }
        
        $timestamps = array_keys($mirrorFiles);
        rsort($timestamps);
        
        $toDelete = array_slice($timestamps, $keepLast);
        $deletedCount = 0;
        
        foreach ($toDelete as $timestamp) {
            // Eliminar todos los archivos de este timestamp
            $filesToDelete = [
                $mirrorDir . DIRECTORY_SEPARATOR . "*_mirror_{$timestamp}.txt",
                $mirrorDir . DIRECTORY_SEPARATOR . "indexes" . DIRECTORY_SEPARATOR . "*_index_{$timestamp}.txt",
                $mirrorDir . DIRECTORY_SEPARATOR . "complete_mirror_{$timestamp}.txt",
                $mirrorDir . DIRECTORY_SEPARATOR . "complete_index_{$timestamp}.txt",
                $mirrorDir . DIRECTORY_SEPARATOR . "metadata_{$timestamp}.json"
            ];
            
            foreach ($filesToDelete as $pattern) {
                foreach (glob($pattern) as $file) {
                    if (file_exists($file)) {
                        unlink($file);
                        $deletedCount++;
                    }
                }
            }
        }
        
        return $deletedCount;
    }

    /**
     * MÉTODO NUEVO - Diagnóstico mejorado
     */
    public function checkStoragePaths()
    {
        echo "🔍 DIAGNÓSTICO DE RUTAS:\n";
        echo "Base path: " . base_path() . "\n";
        echo "Storage path: " . storage_path() . "\n";
        echo "Storage app path: " . storage_path('app') . "\n";
        echo "Mirror path: " . storage_path('app/mirrors') . "\n";
        echo "Index path: " . storage_path('app/mirrors/indexes') . "\n";
        
        echo "\n📁 VERIFICANDO DIRECTORIOS:\n";
        $directories = [
            storage_path('app'),
            storage_path('app/mirrors'),
            storage_path('app/mirrors/indexes')
        ];
        
        foreach ($directories as $dir) {
            if (file_exists($dir)) {
                echo "✅ Existe: {$dir}\n";
                echo "   Permisos: " . substr(sprintf('%o', fileperms($dir)), -4) . "\n";
                $fileCount = count(glob($dir . DIRECTORY_SEPARATOR . '*'));
                echo "   Archivos: {$fileCount}\n";
            } else {
                echo "❌ No existe: {$dir}\n";
                mkdir($dir, 0755, true);
                echo "✅ Creado: {$dir}\n";
            }
        }
        
        echo "\n📄 ARCHIVOS EXISTENTES:\n";
        $mirrorDir = storage_path('app/mirrors');
        if (file_exists($mirrorDir)) {
            $files = glob($mirrorDir . DIRECTORY_SEPARATOR . '*.txt');
            $jsonFiles = glob($mirrorDir . DIRECTORY_SEPARATOR . '*.json');
            $allFiles = array_merge($files, $jsonFiles);
            
            if (empty($allFiles)) {
                echo "❌ No hay archivos en mirrors/\n";
            } else {
                foreach ($allFiles as $file) {
                    $basename = basename($file);
                    $size = filesize($file);
                    echo "✅ {$basename} ({$size} bytes)\n";
                }
            }
        } else {
            echo "❌ Directorio mirrors no existe\n";
        }
    }
}