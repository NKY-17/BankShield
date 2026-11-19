
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Receiver - BankShield</title>
</head>
<body>

    <h2>Add New Saved Receiver</h2>

    <a href="{{ route('saved-receivers.index') }}">
        Back to Receivers
    </a>

    <form action="{{ route('saved-receivers.store') }}" method="POST">

        @csrf

        @include('saved-receivers._form')

        <button type="submit">Save Receiver</button>

    </form>

</body>
</html>
