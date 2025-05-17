<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - TripNJoy</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Estilos personalizados -->
    <style>
        .sidebar {
            background-color: #343a40;
            min-height: 100vh;
            color: white;
        }
        
        .sidebar a {
            color: #c2c7d0;
            display: block;
            padding: 10px 15px;
            text-decoration: none;
        }
        
        .sidebar a:hover {
            color: white;
            background-color: #4b545c;
        }
        
        .sidebar .active {
            background-color: #007bff;
            color: white;
        }
        
        .content-wrapper {
            min-height: 100vh;
            padding: 20px;
            background-color: #f4f6f9;
        }
        
        .navbar {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
        }
        
        .navbar-brand {
            color: #343a40;
            font-weight: bold;
        }
        
        .form-control-static {
            font-weight: 500;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar px-0">
                <div class="d-flex flex-column">
                    <div class="py-3 text-center">
                        <h3>TripNJoy</h3>
                        <p class="small mb-0">Panel de Administración</p>
                    </div>
                    
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt fa-fw mr-2"></i> Dashboard
                    </a>
                    
                    <a href="#" class="{{ request()->routeIs('admin.hotels*') ? 'active' : '' }}">
                        <i class="fas fa-hotel fa-fw mr-2"></i> Hoteles
                    </a>
                    
                    <a href="#" class="{{ request()->routeIs('admin.types*') ? 'active' : '' }}">
                        <i class="fas fa-bed fa-fw mr-2"></i> Tipos de Habitación
                    </a>
                    
                    <a href="#" class="{{ request()->routeIs('admin.rooms*') ? 'active' : '' }}">
                        <i class="fas fa-door-open fa-fw mr-2"></i> Habitaciones
                    </a>
                    
                    <a href="#" class="{{ request()->routeIs('admin.reservations*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-check fa-fw mr-2"></i> Reservas
                    </a>
                    
                    <a href="#" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        <i class="fas fa-users fa-fw mr-2"></i> Usuarios
                    </a>
                    
                    <a href="#" class="{{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                        <i class="fas fa-star fa-fw mr-2"></i> Reseñas
                    </a>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ml-sm-auto px-0">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user-circle fa-fw"></i> 
                                        {{ Auth::user()->name ?? 'Usuario' }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-user fa-fw"></i> Perfil</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-sign-out-alt fa-fw"></i> Cerrar Sesión
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                
                <!-- Content -->
                <main class="content-wrapper">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts adicionales -->
    @yield('scripts')
</body>
</html>