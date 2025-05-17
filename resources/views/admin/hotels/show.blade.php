@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Detalles del Hotel</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.hotels') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al listado
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre del Hotel:</label>
                                <p class="form-control-static">{{ $hotel->name }}</p>
                            </div>
                            
                            <div class="form-group">
                                <label>Dirección:</label>
                                <p class="form-control-static">{{ $hotel->address }}</p>
                            </div>
                            
                            <div class="form-group">
                                <label>Ciudad:</label>
                                <p class="form-control-static">{{ $hotel->city }}</p>
                            </div>
                            
                            <div class="form-group">
                                <label>Teléfono:</label>
                                <p class="form-control-static">{{ $hotel->phone }}</p>
                            </div>
                            
                            <div class="form-group">
                                <label>Email:</label>
                                <p class="form-control-static">{{ $hotel->email }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Estrellas:</label>
                                <p class="form-control-static">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $hotel->stars)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </p>
                            </div>
                            
                            <div class="form-group">
                                <label>Estado:</label>
                                <p class="form-control-static">
                                    @if($hotel->active)
                                        <span class="badge badge-success">Activo</span>
                                    @else
                                        <span class="badge badge-danger">Inactivo</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="form-group">
                                <label>Fecha de creación:</label>
                                <p class="form-control-static">{{ $hotel->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            
                            <div class="form-group">
                                <label>Última actualización:</label>
                                <p class="form-control-static">{{ $hotel->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                            
                            <div class="form-group">
                                <label>Imagen Principal:</label>
                                @if($hotel->main_image)
                                    <div>
                                        <img src="{{ asset('storage/' . $hotel->main_image) }}" alt="{{ $hotel->name }}" 
                                            class="img-thumbnail" style="max-height: 200px;">
                                    </div>
                                @else
                                    <p class="form-control-static text-muted">No hay imagen</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-12 mt-4">
                            <div class="form-group">
                                <label>Descripción:</label>
                                <div class="p-3 bg-light rounded">
                                    {{ $hotel->description }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.hotels.edit', $hotel->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Editar Hotel
                                </a>
                                <form action="{{ route('admin.hotels.delete', $hotel->id) }}" method="POST" 
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este hotel?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Eliminar Hotel
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection