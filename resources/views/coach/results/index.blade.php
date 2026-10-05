<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultaten beoordelen | LevelUp</title>

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
            max-width: 1200px;
            margin: 40px auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
        }

        .page-header h2 {
            margin: 0 0 6px;
            font-size: 30px;
        }

        .page-header p {
            margin: 0;
            color: #64748B;
        }

        .back-link {
            color: #475569;
            text-decoration: none;
            font-weight: 700;
        }

        .success-message {
            margin-bottom: 20px;
            padding: 12px 14px;
            border-radius: 8px;
            background: #DCFCE7;
            color: #166534;
            font-weight: 600;
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
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #E2E8F0;
            vertical-align: middle;
        }

        th {
            background: #F1F5F9;
            white-space: nowrap;
        }

        .proof-link {
            color: #2563EB;
            font-weight: 600;
        }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
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

        .actions {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .action-form {
            margin: 0;
        }

        .action-button {
            border: 0;
            border-radius: 6px;
            padding: 7px 9px;
            cursor: pointer;
            font-weight: 700;
            font-size: 12px;
        }

        .approve-button {
            background: #DCFCE7;
            color: #166534;
        }

        .reject-button {
            background: #FEE2E2;
            color: #991B1B;
        }

        .review-button {
            background: #DBEAFE;
            color: #1E40AF;
        }

        .empty-state {
            padding: 30px;
            text-align: center;
            color: #64748B;
        }

        @media (max-width: 700px) {
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
                align-items: flex-start;
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
    <div class="page-header">
        <div>
            <h2>Resultaten beoordelen</h2>
            <p>Controleer de ingediende resultaten van sportleden.</p>
        </div>

        <a
            class="back-link"
            href="{{ route('coach.challenges.index') }}"
        >
            ← Challenges beheren
        </a>
    </div>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <section class="table-card">
        @if ($results->isEmpty())
            <div class="empty-state">
                Er zijn nog geen resultaten ingediend.
            </div>
        @else
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Sportlid</th>
                            <th>Challenge</th>
                            <th>Datum</th>
                            <th>Resultaat</th>
                            <th>Bewijs</th>
                            <th>Status</th>
                            <th>Acties</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($results as $result)
                            @php
                                $statusLabels = [
                                    'pending' => 'In afwachting',
                                    'approved' => 'Goedgekeurd',
                                    'rejected' => 'Afgekeurd',
                                    'review' => 'Controleren',
                                ];
                            @endphp

                            <tr>
                                <td>
                                    {{ $result->participation->user->name }}
                                </td>

                                <td>
                                    {{ $result->participation->challenge->name }}
                                </td>

                                <td>
                                    {{ $result->result_date->format('d-m-Y') }}
                                </td>

                                <td>
                                    {{ $result->value }}
                                    {{ $result->participation->challenge->unit }}
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

                                <td>
                                    <span class="status {{ $result->status }}">
                                        {{ $statusLabels[$result->status] ?? $result->status }}
                                    </span>
                                </td>

                                <td>
                                    <div class="actions">
                                        <form
                                            class="action-form"
                                            method="POST"
                                            action="{{ route('coach.results.status', $result) }}"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <input
                                                type="hidden"
                                                name="status"
                                                value="approved"
                                            >

                                            <button
                                                class="action-button approve-button"
                                                type="submit"
                                            >
                                                Goedkeuren
                                            </button>
                                        </form>

                                        <form
                                            class="action-form"
                                            method="POST"
                                            action="{{ route('coach.results.status', $result) }}"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <input
                                                type="hidden"
                                                name="status"
                                                value="rejected"
                                            >

                                            <button
                                                class="action-button reject-button"
                                                type="submit"
                                            >
                                                Afkeuren
                                            </button>
                                        </form>

                                        <form
                                            class="action-form"
                                            method="POST"
                                            action="{{ route('coach.results.status', $result) }}"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <input
                                                type="hidden"
                                                name="status"
                                                value="review"
                                            >

                                            <button
                                                class="action-button review-button"
                                                type="submit"
                                            >
                                                Controleren
                                            </button>
                                        </form>
                                    </div>
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