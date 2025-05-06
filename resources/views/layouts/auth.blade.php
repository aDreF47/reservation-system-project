<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Acceso') - Sistema de Reservas</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js (para interactividad) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
        }

        .auth-left-side {
            width: 40%; /* Ahora es más pequeño */
            padding: 2rem 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-right-side {
            width: 60%; /* Ahora es más grande */
            background: linear-gradient(135deg, #4F46E5, #7C3AED);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .auth-illustration {
            width: 90%; /* Imagen más grande */
            max-width: 1000px; /* Mayor tamaño máximo */
            z-index: 10;
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .auth-illustration img {
            width: 100%;
            height: auto;
            display: block;
        }

        .auth-logo {
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
        }

        .auth-logo svg {
            color: #4F46E5;
        }

        .auth-form-container {
            max-width: 400px;
            width: 100%;
        }

        .auth-patterns {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0.1;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .login-button {
            width: 100%;
            padding: 0.75rem 1rem;
            background-color: #4F46E5;
            color: white;
            border: none;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .login-button:hover {
            background-color: #4338CA;
        }

        .input-field {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #D1D5DB;
            border-radius: 0.375rem;
            font-size: 1rem;
            margin-top: 0.5rem;
            margin-bottom: 1rem;
        }

        .input-field:focus {
            outline: none;
            border-color: #4F46E5;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        .input-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.25rem;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .forgot-link {
            color: #4F46E5;
            font-size: 0.875rem;
            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.875rem;
            color: #6B7280;
        }

        .register-link a {
            color: #4F46E5;
            font-weight: 500;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .separator {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: #6B7280;
            font-size: 0.875rem;
        }

        .separator::before,
        .separator::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #E5E7EB;
        }

        .separator::before {
            margin-right: 0.5rem;
        }

        .separator::after {
            margin-left: 0.5rem;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .auth-left-side {
                width: 100%;
                padding: 2rem;
                order: 2;
            }

            .auth-right-side {
                width: 100%;
                height: 200px;
                order: 1;
            }

            .auth-illustration {
                width: 90%;
                max-width: 650px;
            }

            .auth-form-container {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="auth-left-side">
        <div class="auth-logo">
            <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span class="ml-3 text-xl font-bold text-gray-900">Sistema de Reservas</span>
        </div>

        <div class="auth-form-container">
            @yield('content')
        </div>
    </div>

    <div class="auth-right-side">
        <div class="auth-patterns"></div>
        <div class="auth-illustration">
            <img src="{{ asset('images/luxury-hotel.jpg') }}" alt="Hotel de lujo" onerror="this.src='https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Nnx8bHV4dXJ5JTIwaG90ZWx8ZW58MHx8MHx8&auto=format&fit=crop&w=800&q=60'; this.onerror=null;">
        </div>
    </div>
</body>
</html>
