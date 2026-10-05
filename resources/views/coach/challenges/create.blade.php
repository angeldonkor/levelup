<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nieuwe challenge | LevelUp</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #F8FAFC;
            color: #0F172A;
        }

        header {
            background: #0F172A;
            color: white;
            padding: 18px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            margin: 0;
            font-size: 28px;
        }

        .logo span {
            color: #EF4444;
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logout-button {
            background: transparent;
            border: 1px solid white;
            color: white;
            padding: 8px 14px;
            border-radius: 7px;
            cursor: pointer;
        }

        main {
            width: 90%;
            max-width: 750px;
            margin: 40px auto;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #475569;
            text-decoration: none;
            font-weight: 600;
        }

        .form-card {
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 28px;
        }

        h2 {
            margin: 0 0 6px;
        }

        .subtitle {
            margin: 0 0 26px;
            color: #64748B;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: 700;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #CBD5E1;
            border-radius: 8px;
            font: inherit;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            outline: 2px solid #22C55E;
            border-color: transparent;
        }

        .field-error {
            display: block;
            margin-top: 6px;
            color: #B91C1C;
            font-size: 14px;
            font-weight: 600;
        }

        .submit-button {
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

        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .form-card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<header>
    <h1 class="logo">Level<span>Up</span></h1>

    <div class="user-area">
        <span>{{ auth()->user()->name }}</span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-button" type="submit">Uitloggen</button>
        </form>
    </div>
</header>

<main>
    <a class="back-link" href="{{ route('coach.challenges.index') }}">
        ← Terug naar challenges
    </a>

    <section class="form-card">
        <h2>Nieuwe challenge</h2>
        <p class="subtitle">Vul de gegevens van de nieuwe challenge in.</p>

        <form method="POST" action="{{ route('coach.challenges.store') }}">
            @csrf

            <div class="form-group">
                <label for="name">Naam</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    required
                >
                @error('name')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="unit">Eenheid</label>
                <input
                    id="unit"
                    name="unit"
                    type="text"
                    value="{{ old('unit') }}"
                    placeholder="Bijvoorbeeld km, kg of herhalingen"
                    required
                >
                @error('unit')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="start_date">Startdatum</label>
                    <input
                        id="start_date"
                        name="start_date"
                        type="date"
                        value="{{ old('start_date') }}"
                        required
                    >
                    @error('start_date')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="end_date">Einddatum</label>
                    <input
                        id="end_date"
                        name="end_date"
                        type="date"
                        value="{{ old('end_date') }}"
                        required
                    >
                    @error('end_date')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="rules">Regels</label>
                <textarea
                    id="rules"
                    name="rules"
                    required
                >{{ old('rules') }}</textarea>

                @error('rules')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="min_value">Minimumwaarde</label>
                    <input
                        id="min_value"
                        name="min_value"
                        type="number"
                        step="0.01"
                        min="0"
                        value="{{ old('min_value') }}"
                        required
                    >
                    @error('min_value')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="max_value">Maximumwaarde</label>
                    <input
                        id="max_value"
                        name="max_value"
                        type="number"
                        step="0.01"
                        min="0"
                        value="{{ old('max_value') }}"
                        required
                    >
                    @error('max_value')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button class="submit-button" type="submit">
                Challenge aanmaken
            </button>
        </form>
    </section>
</main>

</body>
</html>