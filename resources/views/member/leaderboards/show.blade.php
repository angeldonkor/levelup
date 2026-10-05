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
            max-width: 900px;
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
            font-size: 20px;
            font-weight: 700;
        }

        .result {
            font-weight: 700;
        }

        .empty-state {
            padding: 35px;
            text-align: center;
            color: #64748B;
        }

        @media (max-width: 600px) {
            header {
                align-items: flex-start;
            }

            .user-area {
                flex-direction: column;
                align-items: flex-end;
                gap: 8px;
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
    <a class="back-link" href="{{ route('member.dashboard') }}">
        ← Terug naar dashboard
    </a>

    <div class="page-header">
        <h2>{{ $challenge->name }}</h2>
        <p>Leaderboard met de beste goedgekeurde resultaten.</p>
    </div>

    <section class="table-card">
        @if ($leaderboard->isEmpty())
            <div class="empty-state">
                Er staan nog geen resultaten in dit leaderboard.
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

                                <td class="result">
                                    {{ $entry['value'] }}
                                    {{ $challenge->unit }}
                                </td>

                                <td>
                                    {{ $entry['result']->result_date->format('d-m-Y') }}
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