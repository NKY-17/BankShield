
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Receiver - BankShield</title>
</head>
<body>

    <h2>Edit Saved Receiver</h2>

    <a href="{{ route('saved-receivers.index') }}">
        Back to Receivers
    </a>

    <form action="{{ route('saved-receivers.update', $receiver->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        @include('saved-receivers._form')

        <button type="submit">Update Receiver</button>

    </form>

</body>
</html>
