<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | LevelUp</title>

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
            max-width: 1200px;
            margin: 40px auto;
        }

        .welcome {
            margin-bottom: 32px;
        }

        .welcome h2 {
            margin-bottom: 6px;
            font-size: 30px;
        }

        .welcome p {
            color: #64748B;
            margin: 0;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 18px;
        }

        .section-title {
            margin: 0;
        }

        .progress-button {
            display: inline-block;
            padding: 10px 16px;
            background: #0F172A;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
        }

        .progress-button:hover {
            opacity: 0.9;
        }

        .challenge-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .challenge-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            border: 1px solid #E2E8F0;
        }

        .status {
            display: inline-block;
            background: #DCFCE7;
            color: #166534;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .challenge-card h3 {
            margin: 0 0 12px;
        }

        .challenge-card p {
            color: #475569;
            line-height: 1.5;
        }

        .details {
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid #E2E8F0;
        }

        .details div {
            margin-bottom: 7px;
        }

        .join-form {
            margin-top: 18px;
        }

        .join-button {
            width: 100%;
            border: 0;
            border-radius: 8px;
            padding: 11px 14px;
            background: #EF4444;
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }

        .join-button:hover {
            opacity: 0.9;
        }

        .participating {
            margin-top: 18px;
            padding: 11px 14px;
            border-radius: 8px;
            background: #DCFCE7;
            color: #166534;
            text-align: center;
            font-weight: 700;
        }

        .result-button {
            display: block;
            margin-top: 10px;
            padding: 11px 14px;
            border-radius: 8px;
            background: #0F172A;
            color: white;
            text-align: center;
            text-decoration: none;
            font-weight: 700;
        }

        .result-button:hover {
            opacity: 0.9;
        }

        .leaderboard-button {
            display: block;
            margin-top: 10px;
            padding: 11px 14px;
            border-radius: 8px;
            background: #22C55E;
            color: #0F172A;
            text-align: center;
            text-decoration: none;
            font-weight: 700;
        }

        .leaderboard-button:hover {
            opacity: 0.9;
        }

        .success-message {
            margin-bottom: 20px;
            padding: 12px 14px;
            border-radius: 8px;
            background: #DCFCE7;
            color: #166534;
            font-weight: 600;
        }

        .error-message {
            margin-bottom: 20px;
            padding: 12px 14px;
            border-radius: 8px;
            background: #FEE2E2;
            color: #991B1B;
            font-weight: 600;
        }

        .empty-state {
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            color: #64748B;
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

            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .progress-button {
                width: 100%;
                text-align: center;
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
    <section class="welcome">
        <h2>Welkom, {{ auth()->user()->name }}</h2>
        <p>Bekijk de actieve challenges en werk aan je volgende resultaat.</p>
    </section>

    <section>
        @if (session('success'))
            <div class="success-message" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-message" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="section-header">
            <h2 class="section-title">Actieve challenges</h2>

            <a
                class="progress-button"
                href="{{ route('member.progress') }}"
            >
                Mijn voortgang
            </a>
        </div>

        @if ($activeChallenges->isEmpty())
            <div class="empty-state">
                Er zijn momenteel geen actieve challenges.
            </div>
        @else
            <div class="challenge-grid">
                @foreach ($activeChallenges as $challenge)
                    <article class="challenge-card">
                        <span class="status">Actief</span>

                        <h3>{{ $challenge->name }}</h3>

                        <p>{{ $challenge->rules }}</p>

                        <div class="details">
                            <div>
                                <strong>Eenheid:</strong>
                                {{ $challenge->unit }}
                            </div>

                            <div>
                                <strong>Periode:</strong>
                                {{ $challenge->start_date->format('d-m-Y') }}
                                t/m
                                {{ $challenge->end_date->format('d-m-Y') }}
                            </div>
                        </div>

                        @if ($challenge->participations->isNotEmpty())
                            <div class="participating">
                                Je neemt deel
                            </div>

                            <a
                                class="result-button"
                                href="{{ route('member.results.create', $challenge) }}"
                            >
                                Resultaat invoeren
                            </a>
                        @else
                            <form
                                class="join-form"
                                method="POST"
                                action="{{ route('member.challenges.join', $challenge) }}"
                            >
                                @csrf

                                <button class="join-button" type="submit">
                                    Deelnemen
                                </button>
                            </form>
                        @endif

                        @if ($challenge->leaderboard_published)
                            <a
                                class="leaderboard-button"
                                href="{{ route('member.leaderboards.show', $challenge) }}"
                            >
                                Leaderboard bekijken
                            </a>
                        @endif
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</main>

</body>
</html>