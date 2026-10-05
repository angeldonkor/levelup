<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | LevelUp</title>
</head>

<body>
    <h1>Welkom bij LevelUp</h1>

    <p>Ingelogd als: {{ auth()->user()->name }}</p>
    <p>Rol: {{ auth()->user()->role }}</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Uitloggen</button>
    </form>
</body>
</html>