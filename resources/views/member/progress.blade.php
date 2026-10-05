<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mijn voortgang | LevelUp</title>

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
            max-width: 1000px;
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

        h2 {
            margin-bottom: 6px;
        }

        .subtitle {
            margin-top: 0;
            margin-bottom: 28px;
            color: #64748B;
        }

        .challenge-card {
            background: white;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 22px;
        }

        .challenge-card h3 {
            margin-top: 0;
            margin-bottom: 6px;
        }

        .unit {
            color: #64748B;
            margin-top: 0;
            margin-bottom: 20px;
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
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #E2E8F0;
        }

        th {
            background: #F8FAFC;
        }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
        }

        .pending {
            background: #FEF3C7;
            color: #92400E;
        }

        .approved {
            background: #DCFCE7;
            color: #166534;
        }

        .rejected {
            background: #FEE2E2;
            color: #991B1B;
        }

        .review {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .proof-link {
            color: #2563EB;
            font-weight: 600;
        }

        .empty {
            padding: 18px;
            background: #F1F5F9;
            border-radius: 8px;
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

            .challenge-card {
                padding: 18px;
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

    <h2>Mijn voortgang</h2>

    <p class="subtitle">
        Bekijk je resultaten en de status van je inzendingen.
    </p>

    @forelse ($participations as $participation)
        <section class="challenge-card">
            <h3>{{ $participation->challenge->name }}</h3>

            <p class="unit">
                Eenheid: {{ $participation->challenge->unit }}
            </p>

            @if ($participation->results->isEmpty())
                <div class="empty">
                    Je hebt voor deze challenge nog geen resultaten ingediend.
                </div>
            @else
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Datum</th>
                                <th>Resultaat</th>
                                <th>Status</th>
                                <th>Bewijs</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($participation->results as $result)
                                <tr>
                                    <td>
                                        {{ $result->result_date->format('d-m-Y') }}
                                    </td>

                                    <td>
                                        {{ $result->value }}
                                        {{ $participation->challenge->unit }}
                                    </td>

                                    <td>
                                        @php
                                            $statusLabels = [
                                                'pending' => 'In afwachting',
                                                'approved' => 'Goedgekeurd',
                                                'rejected' => 'Afgekeurd',
                                                'review' => 'Controleren',
                                            ];
                                        @endphp

                                        <span class="status {{ $result->status }}">
                                            {{ $statusLabels[$result->status] ?? $result->status }}
                                        </span>
                                    </td>

                                    <td>
                                        <a
                                            class="proof-link"
                                            href="{{ $result->proof_url }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            Bekijk bewijs
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    @empty
        <div class="empty">
            Je neemt nog niet deel aan een challenge.
        </div>
    @endforelse
</main>

</body>
</html>