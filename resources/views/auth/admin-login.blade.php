<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>
    <style>
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .success-message {
            color: green;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Login de Administrador</h1>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="color: red; margin-bottom: 20px;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.login.post') }}" method="POST">
        @csrf

        <label for="email">
            Email:
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </label>
        <br><br>

        <label for="password">
            Password:
            <input type="password" name="password" id="password" required>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </label>
        <br><br>

        <button type="submit">Iniciar Sesión</button>
    </form>

    <hr style="margin-top: 30px;">

    <p><small>Para probar, crea un admin con: email: admin@admin.com, password: admin123, role: admin</small></p>
</body>
</html>
