<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen | LevelUp</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            background: #0F172A;
            color: #0F172A;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #F8FAFC;
            border-radius: 16px;
            padding: 36px;
        }

        .logo {
            margin: 0 0 8px;
            font-size: 32px;
            font-weight: 800;
        }

        .logo span {
            color: #EF4444;
        }

        .subtitle {
            margin: 0 0 28px;
            color: #64748B;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font-size: 16px;
        }

        input:focus {
            outline: 2px solid #22C55E;
            border-color: transparent;
        }

        button {
            width: 100%;
            border: 0;
            border-radius: 8px;
            padding: 13px;
            background: #EF4444;
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.9;
        }

        .error {
            background: #FEE2E2;
            color: #991B1B;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 18px;
        }
    </style>
</head>

<body>
    <main class="login-card">
        <h1 class="logo">Level<span>Up</span></h1>
        <p class="subtitle">Log in om verder te gaan.</p>

        @if ($errors->any())
            <div class="error" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf

            <div class="form-group">
                <label for="email">E-mailadres</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                >
            </div>

            <div class="form-group">
                <label for="password">Wachtwoord</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    autocomplete="current-password"
                >
            </div>

            <button type="submit">Inloggen</button>
        </form>
    </main>
</body>
</html>