<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Puedes incluir tus CSS aquí -->
</head>
<body>
    <h1>Iniciar Sesión</h1>
    
    <!-- Mostrar mensajes de error o de éxito -->
    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div>
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" required value="{{ old('email') }}">
        </div>
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <button type="submit">Ingresar</button>
        </div>
    </form>
</body>
</html>
