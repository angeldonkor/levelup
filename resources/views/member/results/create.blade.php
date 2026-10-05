<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultaat invoeren | LevelUp</title>

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
            border: 1px solid #F8FAFC;
            color: white;
            padding: 8px 14px;
            border-radius: 7px;
            cursor: pointer;
        }

        main {
            width: 90%;
            max-width: 700px;
            margin: 40px auto;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #475569;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .form-card {
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 28px;
        }

        .form-card h2 {
            margin-top: 0;
            margin-bottom: 8px;
        }

        .description {
            color: #64748B;
            margin-top: 0;
            margin-bottom: 24px;
        }

        .challenge-info {
            background: #F1F5F9;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .challenge-info div {
            margin-bottom: 6px;
        }

        .challenge-info div:last-child {
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: 700;
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

        .field-help {
            display: block;
            margin-top: 6px;
            color: #64748B;
            font-size: 14px;
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
            padding: 13px 16px;
            background: #EF4444;
            color: white;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
        }

        .submit-button:hover {
            opacity: 0.9;
        }

        @media (max-width: 600px) {
            header {
                align-items: flex-start;
                gap: 15px;
            }

            .user-area {
                flex-direction: column;
                align-items: flex-end;
                gap: 8px;
            }

            main {
                margin-top: 25px;
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
            <button class="logout-button" type="submit">
                Uitloggen
            </button>
        </form>
    </div>
</header>

<main>
    <a class="back-link" href="{{ route('member.dashboard') }}">
        ← Terug naar dashboard
    </a>

    <section class="form-card">
        <h2>Resultaat invoeren</h2>

        <p class="description">
            Dien je resultaat in voor {{ $challenge->name }}.
        </p>

        <div class="challenge-info">
            <div>
                <strong>Challenge:</strong>
                {{ $challenge->name }}
            </div>

            <div>
                <strong>Eenheid:</strong>
                {{ $challenge->unit }}
            </div>

            <div>
                <strong>Toegestane waarde:</strong>
                {{ $challenge->min_value }}
                t/m
                {{ $challenge->max_value }}
                {{ $challenge->unit }}
            </div>

            <div>
                <strong>Periode:</strong>
                {{ $challenge->start_date->format('d-m-Y') }}
                t/m
                {{ $challenge->end_date->format('d-m-Y') }}
            </div>
        </div>

        <form
            method="POST"
            action="{{ route('member.results.store', $challenge) }}"
        >
            @csrf

            <div class="form-group">
                <label for="result_date">Datum</label>

                <input
                    type="date"
                    id="result_date"
                    name="result_date"
                    value="{{ old('result_date') }}"
                    min="{{ $challenge->start_date->format('Y-m-d') }}"
                    max="{{ $challenge->end_date->format('Y-m-d') }}"
                    required
                >

                @error('result_date')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="value">
                    Resultaat ({{ $challenge->unit }})
                </label>

                <input
                    type="number"
                    id="value"
                    name="value"
                    value="{{ old('value') }}"
                    min="{{ $challenge->min_value }}"
                    max="{{ $challenge->max_value }}"
                    step="0.01"
                    required
                >

                <span class="field-help">
                    Minimaal {{ $challenge->min_value }} en maximaal
                    {{ $challenge->max_value }} {{ $challenge->unit }}.
                </span>

                @error('value')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="proof_url">Bewijslink</label>

                <input
                    type="url"
                    id="proof_url"
                    name="proof_url"
                    value="{{ old('proof_url') }}"
                    placeholder="https://voorbeeld.nl/bewijs"
                    required
                >

                <span class="field-help">
                    Voeg een link toe naar het bewijs van je resultaat.
                </span>

                @error('proof_url')
                    <span class="field-error">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <button class="submit-button" type="submit">
                Resultaat indienen
            </button>
        </form>
    </section>
</main>

</body>
</html>