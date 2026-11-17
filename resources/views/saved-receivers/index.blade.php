
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Saved Receivers - BankShield</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
            padding: 30px;
        }
        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: #1e293b;
            color: white;
        }
        a, button {
            padding: 8px 12px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .add {
            background: #16a34a;
            color: white;
        }
        .edit {
            background: #2563eb;
            color: white;
        }
        .delete {
            background: #dc2626;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>BankShield - Saved Receivers</h2>

    <p>Manage your saved bank receivers.</p>

    <a href="{{ route('saved-receivers.create') }}" class="add">
        + Add New Receiver
    </a>

    @if(session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Receiver Name</th>
                <th>Bank Name</th>
                <th>Account Number</th>
                <th>Nickname</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($receivers as $receiver)
                <tr>
                    <td>{{ $receiver->id }}</td>
                    <td>{{ $receiver->receiver_name }}</td>
                    <td>{{ $receiver->bank_name }}</td>
                    <td>
                        ••••{{ substr($receiver->account_number, -4) }}
                    </td>
                    <td>{{ $receiver->nickname ?? 'N/A' }}</td>
                    <td>
                        <a class="edit"
                           href="{{ route('saved-receivers.edit', $receiver->id) }}">
                            Edit
                        </a>

                        <form action="{{ route('saved-receivers.destroy', $receiver->id) }}"
                              method="POST"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="delete"
                                onclick="return confirm('Are you sure you want to delete this receiver?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;">
                        No saved receivers found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

</body>
</html>
