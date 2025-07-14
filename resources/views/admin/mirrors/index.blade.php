@extends('layouts.admin')
@section('title', 'Gestión de Mirrors')

@section('content')
<div class="container-fluid p-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">🗃️ Gestión de Mirrors de Base de Datos</h1>
            <p class="text-muted">Sistema de réplica indexada para acceso directo</p>
        </div>
        <div>
            <button type="button" class="btn btn-primary" onclick="generateMirror()">
                <i class="fas fa-sync-alt"></i> Generar Mirror
            </button>
            <button type="button" class="btn btn-warning" onclick="cleanupMirrors()">
                <i class="fas fa-broom"></i> Limpiar Antiguos
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['total_files'] }}</h4>
                            <p class="card-text">Total Archivos</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-file fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['mirror_files'] }}</h4>
                            <p class="card-text">Archivos Mirror</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-database fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['index_files'] }}</h4>
                            <p class="card-text">Archivos Índice</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-search fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['total_size_human'] }}</h4>
                            <p class="card-text">Tamaño Total</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-hdd fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">🔍 Buscar en Mirror</h5>
        </div>
        <div class="card-body">
            <form id="searchForm" class="row g-3">
                <div class="col-md-3">
                    <label for="searchTable" class="form-label">Tabla</label>
                    <select class="form-select" id="searchTable" required>
                        <option value="">Seleccionar tabla...</option>
                        <option value="hotels">Hotels</option>
                        <option value="users">Users</option>
                        <option value="reservations">Reservations</option>
                        <option value="rooms">Rooms</option>
                        <option value="room_types">Room Types</option>
                        <option value="payments">Payments</option>
                        <option value="reviews">Reviews</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="searchField" class="form-label">Campo</label>
                    <select class="form-select" id="searchField" required>
                        <option value="">Seleccionar campo...</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="searchValue" class="form-label">Valor</label>
                    <input type="text" class="form-control" id="searchValue" placeholder="Valor a buscar..." required>
                </div>
                <div class="col-md-3">
                    <label for="searchTimestamp" class="form-label">Mirror</label>
                    <select class="form-select" id="searchTimestamp">
                        <option value="">Último mirror</option>
                        @foreach($mirrors as $mirror)
                        <option value="{{ $mirror['timestamp'] }}">{{ $mirror['timestamp'] }} ({{ $mirror['total_records'] }} registros)</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Search Results -->
    <div id="searchResults" class="card mb-4" style="display: none;">
        <div class="card-header">
            <h5 class="mb-0">📋 Resultados de Búsqueda</h5>
        </div>
        <div class="card-body">
            <div id="resultsContent"></div>
        </div>
    </div>

    <!-- Available Mirrors -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">📚 Mirrors Disponibles</h5>
        </div>
        <div class="card-body">
            @if(count($mirrors) > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>Fecha Generación</th>
                            <th>Total Registros</th>
                            <th>Tablas</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mirrors as $mirror)
                        <tr>
                            <td><code>{{ $mirror['timestamp'] }}</code></td>
                            <td>{{ \Carbon\Carbon::parse($mirror['generated_at'])->format('d/m/Y H:i:s') }}</td>
                            <td><span class="badge bg-info">{{ number_format($mirror['total_records']) }}</span></td>
                            <td>
                                @foreach($mirror['tables'] as $table => $info)
                                <span class="badge bg-secondary me-1">{{ $table }} ({{ $info['record_count'] }})</span>
                                @endforeach
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    @foreach($mirror['tables'] as $table => $info)
                                    <a href="{{ route('admin.mirrors.download', [$table, $mirror['timestamp']]) }}" 
                                       class="btn btn-sm btn-outline-primary" title="Descargar {{ $table }}">
                                        <i class="fas fa-download"></i> {{ $table }}
                                    </a>
                                    @endforeach
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="deleteMirror('{{ $mirror['timestamp'] }}')" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4">
                <i class="fas fa-database fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No hay mirrors disponibles</h5>
                <p class="text-muted">Genera tu primer mirror para comenzar</p>
                <button type="button" class="btn btn-primary" onclick="generateMirror()">
                    <i class="fas fa-sync-alt"></i> Generar Primer Mirror
                </button>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
                <h5 id="loadingText">Generando mirror...</h5>
                <p class="text-muted">Este proceso puede tomar varios minutos</p>
            </div>
        </div>
    </div>
</div>

<script>
// Configuración de campos por tabla
const tableFields = {
    'hotels': ['id', 'name', 'city'],
    'users': ['id', 'email', 'name'],
    'reservations': ['id', 'user_id', 'room_id', 'status'],
    'rooms': ['id', 'room_type_id', 'room_number'],
    'room_types': ['id', 'hotel_id', 'name'],
    'payments': ['id', 'reservation_id', 'status'],
    'reviews': ['id', 'hotel_id', 'user_id', 'rating']
};

// Actualizar campos cuando cambia la tabla
document.getElementById('searchTable').addEventListener('change', function() {
    const table = this.value;
    const fieldSelect = document.getElementById('searchField');
    
    fieldSelect.innerHTML = '<option value="">Seleccionar campo...</option>';
    
    if (table && tableFields[table]) {
        tableFields[table].forEach(field => {
            fieldSelect.innerHTML += `<option value="${field}">${field}</option>`;
        });
    }
});

// Generar mirror
function generateMirror() {
    const modal = new bootstrap.Modal(document.getElementById('loadingModal'));
    modal.show();
    
    fetch('{{ route("admin.mirrors.generate") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        modal.hide();
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: data.message,
                showConfirmButton: true
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            });
        }
    })
    .catch(error => {
        modal.hide();
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error de conexión: ' + error.message
        });
    });
}

// Buscar en mirror
document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = {
        table: document.getElementById('searchTable').value,
        field: document.getElementById('searchField').value,
        value: document.getElementById('searchValue').value,
        timestamp: document.getElementById('searchTimestamp').value
    };
    
    fetch('{{ route("admin.mirrors.search") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        const resultsDiv = document.getElementById('searchResults');
        const contentDiv = document.getElementById('resultsContent');
        
        if (data.success) {
            let html = `<div class="alert alert-info">Encontrados ${data.count} registros</div>`;
            
            if (data.count > 0) {
                html += '<div class="table-responsive"><table class="table table-sm table-striped"><thead><tr>';
                
                // Headers
                const firstRecord = data.data[0];
                for (const key in firstRecord) {
                    html += `<th>${key}</th>`;
                }
                html += '</tr></thead><tbody>';
                
                // Rows
                data.data.forEach(record => {
                    html += '<tr>';
                    for (const key in record) {
                        let value = record[key];
                        if (typeof value === 'string' && value.length > 50) {
                            value = value.substring(0, 50) + '...';
                        }
                        html += `<td>${value || '-'}</td>`;
                    }
                    html += '</tr>';
                });
                
                html += '</tbody></table></div>';
            }
            
            contentDiv.innerHTML = html;
            resultsDiv.style.display = 'block';
            resultsDiv.scrollIntoView({ behavior: 'smooth' });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error en búsqueda',
                text: data.message
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error de conexión: ' + error.message
        });
    });
});

// Eliminar mirror - FUNCIÓN CORREGIDA
function deleteMirror(timestamp) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: `Se eliminará el mirror ${timestamp} permanentemente`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // CORRECCIÓN: Construir la URL correctamente
            const deleteUrl = '{{ route("admin.mirrors.index") }}' + '/mirrors/' + timestamp;
            
            fetch(deleteUrl, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('¡Eliminado!', data.message, 'success')
                        .then(() => location.reload());
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Error de conexión: ' + error.message, 'error');
            });
        }
    });
}

// Limpiar mirrors antiguos
function cleanupMirrors() {
    Swal.fire({
        title: 'Limpiar mirrors antiguos',
        input: 'number',
        inputLabel: '¿Cuántos mirrors recientes mantener?',
        inputValue: 5,
        inputAttributes: {
            min: 1,
            max: 20
        },
        showCancelButton: true,
        confirmButtonText: 'Limpiar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('{{ route("admin.mirrors.cleanup") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ keep: result.value })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('¡Limpieza completada!', data.message, 'success')
                        .then(() => location.reload());
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            });
        }
    });
}
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection