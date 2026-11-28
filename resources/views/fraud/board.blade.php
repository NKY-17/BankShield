<!DOCTYPE html>
<html>
<head>
    <title>Fraud Case Board - BankShield</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 25px;
        }

        h1 {
            color: #173b67;
            text-align: center;
        }

        .board {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 30px;
        }

        .column {
            background: #e2e8f0;
            padding: 15px;
            border-radius: 10px;
            min-height: 300px;
        }

        .column h2 {
            text-align: center;
            color: #173b67;
            font-size: 18px;
        }

        .case {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        }

        .case p {
            font-size: 14px;
            color: #475569;
            overflow-wrap: anywhere;
        }

        textarea, select {
            width: 100%;
            padding: 9px;
            margin-top: 8px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background: #173b67;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 6px;
        }

        .empty {
            text-align: center;
            color: #64748b;
            font-size: 14px;
        }

        @media (max-width: 800px) {
            .board {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <h1>BankShield Fraud Case Board</h1>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <div class="board">

        <!-- New Cases -->
        <div class="column">
            <h2>New</h2>

            @forelse($cases->where('stage', 'new') as $case)

                <div class="case">
                    <h3>Case #{{ $case->id }}</h3>

                    <p>
                        <strong>Customer:</strong>
                        {{ $case->fraudLog->account->customer->first_name ?? 'Unknown' }}
                        {{ $case->fraudLog->account->customer->last_name ?? '' }}
                    </p>

                    <p>
                        <strong>Account:</strong>
                        {{ $case->fraudLog->account->account_number }}
                    </p>

                    <p>
                        <strong>Amount:</strong>
                        ৳{{ number_format($case->fraudLog->amount, 2) }}
                    </p>

                    <p>
                        <strong>Reason:</strong>
                        {{ $case->fraudLog->reason }}
                    </p>

                    <p>
                        <strong>Verification:</strong>
                        {{ ucfirst($case->fraudLog->status) }}
                    </p>

                    <form method="POST" action="{{ route('fraud.cases.update', $case->id) }}">
                        @csrf
                        @method('PATCH')

                        <select name="stage" required>
                            <option value="new">New</option>
                            <option value="under_investigation">Under Investigation</option>
                            <option value="resolved">Resolved</option>
                        </select>

                        <textarea name="investigation_notes" rows="3" placeholder="Investigation notes">{{ $case->investigation_notes }}</textarea>

                        <button type="submit">Update Case</button>
                    </form>
                </div>

            @empty
                <p class="empty">No new cases.</p>
            @endforelse
        </div>

        <!-- Under Investigation -->
        <div class="column">
            <h2>Under Investigation</h2>

            @forelse($cases->where('stage', 'under_investigation') as $case)

                <div class="case">
                    <h3>Case #{{ $case->id }}</h3>

                    <p>
                        <strong>Amount:</strong>
                        ৳{{ number_format($case->fraudLog->amount, 2) }}
                    </p>

                    <p>
                        <strong>Reason:</strong>
                        {{ $case->fraudLog->reason }}
                    </p>

                    <form method="POST" action="{{ route('fraud.cases.update', $case->id) }}">
                        @csrf
                        @method('PATCH')

                        <select name="stage" required>
                            <option value="new">New</option>
                            <option value="under_investigation" selected>Under Investigation</option>
                            <option value="resolved">Resolved</option>
                        </select>

                        <textarea name="investigation_notes" rows="3" placeholder="Investigation notes">{{ $case->investigation_notes }}</textarea>

                        <button type="submit">Update Case</button>
                    </form>
                </div>

            @empty
                <p class="empty">No cases under investigation.</p>
            @endforelse
        </div>

        <!-- Resolved Cases -->
        <div class="column">
            <h2>Resolved</h2>

            @forelse($cases->where('stage', 'resolved') as $case)

                <div class="case">
                    <h3>Case #{{ $case->id }}</h3>

                    <p>
                        <strong>Amount:</strong>
                        ৳{{ number_format($case->fraudLog->amount, 2) }}
                    </p>

                    <p>
                        <strong>Reason:</strong>
                        {{ $case->fraudLog->reason }}
                    </p>

                    <p>
                        <strong>Investigation Notes:</strong>
                        {{ $case->investigation_notes ?? 'No notes added.' }}
                    </p>

                    <form method="POST" action="{{ route('fraud.cases.update', $case->id) }}">
                        @csrf
                        @method('PATCH')

                        <select name="stage" required>
                            <option value="new">New</option>
                            <option value="under_investigation">Under Investigation</option>
                            <option value="resolved" selected>Resolved</option>
                        </select>

                        <textarea name="investigation_notes" rows="3" placeholder="Update investigation notes">{{ $case->investigation_notes }}</textarea>

                        <button type="submit">Update Case</button>
                    </form>
                </div>

            @empty
                <p class="empty">No resolved cases.</p>
            @endforelse
        </div>

    </div>

</body>
</html>
