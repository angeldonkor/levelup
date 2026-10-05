<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard | LevelUp</title>

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
            max-width: 1000px;
            margin: 40px auto;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 22px;
            color: #475569;
            text-decoration: none;
            font-weight: 700;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 25px;
        }

        .page-header h2 {
            margin: 0 0 7px;
            font-size: 30px;
        }

        .page-header p {
            margin: 0;
            color: #64748B;
        }

        .publish-button,
        .unpublish-button {
            border: 0;
            border-radius: 8px;
            padding: 11px 16px;
            color: white;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
        }

        .publish-button {
            background: #22C55E;
        }

        .unpublish-button {
            background: #EF4444;
        }

        .success-message {
            margin-bottom: 20px;
            padding: 12px 14px;
            border-radius: 8px;
            background: #DCFCE7;
            color: #166534;
            font-weight: 600;
        }

        .publication-status {
            margin-bottom: 20px;
            padding: 14px;
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
        }

        .published {
            color: #166534;
            font-weight: 700;
        }

        .not-published {
            color: #991B1B;
            font-weight: 700;
        }

        .table-card {
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            overflow: hidden;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #E2E8F0;
        }

        th {
            background: #F1F5F9;
        }

        .position {
            font-size: 18px;
            font-weight: 700;
        }

        .approved {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 999px;
            background: #DCFCE7;
            color: #166534;
            font-size: 13px;
            font-weight: 700;
        }

        .empty-state {
            padding: 35px;
            text-align: center;
            color: #64748B;
        }

        @media (max-width: 650px) {
            header {
                align-items: flex-start;
            }

            .user-area {
                flex-direction: column;
                align-items: flex-end;
                gap: 8px;
            }

            .page-header {
                flex-direction: column;
            }

            .page-header form,
            .publish-button,
            .unpublish-button {
                width: 100%;
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

    <div class="page-header">
        <div>
            <h2>{{ $challenge->name }}</h2>
            <p>Leaderboard op basis van goedgekeurde resultaten.</p>
        </div>

        @if ($challenge->leaderboard_published)
            <form
                method="POST"
                action="{{ route('coach.leaderboards.unpublish', $challenge) }}"
            >
                @csrf
                @method('PATCH')

                <button class="unpublish-button" type="submit">
                    Publicatie stoppen
                </button>
            </form>
        @else
            <form
                method="POST"
                action="{{ route('coach.leaderboards.publish', $challenge) }}"
            >
                @csrf
                @method('PATCH')

                <button class="publish-button" type="submit">
                    Leaderboard publiceren
                </button>
            </form>
        @endif
    </div>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="publication-status">
        <strong>Publicatiestatus:</strong>

        @if ($challenge->leaderboard_published)
            <span class="published">Gepubliceerd</span>
        @else
            <span class="not-published">Niet gepubliceerd</span>
        @endif
    </div>

    <section class="table-card">
        @if ($leaderboard->isEmpty())
            <div class="empty-state">
                Er zijn nog geen goedgekeurde resultaten voor deze challenge.
            </div>
        @else
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Positie</th>
                            <th>Sportlid</th>
                            <th>Resultaat</th>
                            <th>Datum</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($leaderboard as $entry)
                            <tr>
                                <td class="position">
                                    #{{ $loop->iteration }}
                                </td>

                                <td>
                                    {{ $entry['user']->name }}
                                </td>

                                <td>
                                    <strong>{{ $entry['value'] }}</strong>
                                    {{ $challenge->unit }}
                                </td>

                                <td>
                                    {{ $entry['result']->result_date->format('d-m-Y') }}
                                </td>

                                <td>
                                    <span class="approved">
                                        Goedgekeurd
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</main>

</body>
</html>