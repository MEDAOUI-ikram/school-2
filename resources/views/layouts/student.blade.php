<!DOCTYPE html>
<html>
<head>
    <title>Interface Étudiant</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>Bienvenue Étudiant</h1>
        <nav>
            <a href="{{ route('etudiant.classes') }}">Mes classes</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
</body>
</html>
