<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Dashboard | LevelUp</title>

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
            margin-bottom: 30px;
        }

        .welcome h2 {
            margin: 0 0 6px;
            font-size: 30px;
        }

        .welcome p {
            margin: 0;
            color: #64748B;
        }

        .navigation {
            display: flex;
            gap: 12px;
            margin-bottom: 32px;
            flex-wrap: wrap;
        }

        .nav-button {
            display: inline-block;
            padding: 11px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
        }

        .nav-button.primary {
            background: #EF4444;
            color: white;
        }

        .nav-button.secondary {
            background: #0F172A;
            color: white;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .page-header h3 {
            margin: 0;
            font-size: 23px;
        }

        .create-button {
            display: inline-block;
            background: #EF4444;
            color: white;
            padding: 11px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            white-space: nowrap;
        }

        .success-message {
            margin-bottom: 20px;
            padding: 12px 14px;
            border-radius: 8px;
            background: #DCFCE7;
            color: #166534;
            font-weight: 600;
        }

        .challenge-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .challenge-card {
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 24px;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .active {
            background: #DCFCE7;
            color: #166534;
        }

        .upcoming {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .finished {
            background: #E2E8F0;
            color: #475569;
        }

        .challenge-card h3 {
            margin: 0 0 10px;
        }

        .rules {
            color: #475569;
            line-height: 1.5;
        }

        .details {
            margin-top: 18px;
            padding-top: 18px;
            border-top: 1px solid #E2E8F0;
        }

        .details div {
            margin-bottom: 8px;
        }

        .publication {
            margin-top: 12px;
            font-size: 14px;
            font-weight: 700;
        }

        .publication.yes {
            color: #166534;
        }

        .publication.no {
            color: #64748B;
        }

        .actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 9px;
            margin-top: 20px;
        }

        .action-button {
            padding: 10px 12px;
            border-radius: 8px;
            font-weight: 700;
            text-align: center;
            font-size: 14px;
        }

        .edit-button {
            background: #0F172A;
            color: white;
            text-decoration: none;
        }

        .leaderboard-button {
            background: #22C55E;
            color: #0F172A;
            text-decoration: none;
        }

        .delete-form {
            grid-column: 1 / -1;
        }

        .delete-button {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #EF4444;
            background: white;
            color: #EF4444;
            font-weight: 700;
            cursor: pointer;
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

            .navigation {
                flex-direction: column;
            }

            .nav-button {
                text-align: center;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .create-button {
                width: 100%;
                text-align: center;
            }

            .actions {
                grid-template-columns: 1fr;
            }

            .delete-form {
                grid-column: auto;
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
        <h2>Coach dashboard</h2>
        <p>Beheer challenges, beoordeel resultaten en publiceer leaderboards.</p>
    </section>

    <nav class="navigation">
        <a
            class="nav-button primary"
            href="{{ route('coach.challenges.create') }}"
        >
            + Nieuwe challenge
        </a>

        <a
            class="nav-button secondary"
            href="{{ route('coach.results.index') }}"
        >
            Resultaten beoordelen
        </a>
    </nav>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="page-header">
        <h3>Challenges beheren</h3>
    </div>

    @if ($challenges->isEmpty())
        <div class="empty-state">
            Er zijn nog geen challenges aangemaakt.
        </div>
    @else
        <div class="challenge-grid">
            @foreach ($challenges as $challenge)
                <article class="challenge-card">

                    @if ($challenge->start_date->isAfter(today()))
                        <span class="status upcoming">
                            Binnenkort
                        </span>
                    @elseif ($challenge->end_date->isBefore(today()))
                        <span class="status finished">
                            Afgelopen
                        </span>
                    @else
                        <span class="status active">
                            Actief
                        </span>
                    @endif

                    <h3>{{ $challenge->name }}</h3>

                    <p class="rules">
                        {{ $challenge->rules }}
                    </p>

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

                        <div>
                            <strong>Minimum:</strong>
                            {{ $challenge->min_value }}
                            {{ $challenge->unit }}
                        </div>

                        <div>
                            <strong>Maximum:</strong>
                            {{ $challenge->max_value }}
                            {{ $challenge->unit }}
                        </div>
                    </div>

                    @if ($challenge->leaderboard_published)
                        <div class="publication yes">
                            Leaderboard gepubliceerd
                        </div>
                    @else
                        <div class="publication no">
                            Leaderboard niet gepubliceerd
                        </div>
                    @endif

                    <div class="actions">
                        <a
                            class="action-button edit-button"
                            href="{{ route('coach.challenges.edit', $challenge) }}"
                        >
                            Bewerken
                        </a>

                        <a
                            class="action-button leaderboard-button"
                            href="{{ route('coach.leaderboards.show', $challenge) }}"
                        >
                            Leaderboard
                        </a>

                        <form
                            class="delete-form"
                            method="POST"
                            action="{{ route('coach.challenges.destroy', $challenge) }}"
                            onsubmit="return confirm('Weet je zeker dat je deze challenge wilt verwijderen?');"
                        >
                            @csrf
                            @method('DELETE')

                            <button class="delete-button" type="submit">
                                Verwijderen
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</main>

</body>
</html>