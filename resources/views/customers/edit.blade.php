<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer | BankShield</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 30px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
        }

        h1 {
            color: #1e3a8a;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
        }

        button {
            background: #1e40af;
            color: white;
            border: none;
            padding: 12px 22px;
            border-radius: 6px;
            cursor: pointer;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        .back {
            display: inline-block;
            margin-bottom: 20px;
            color: #1e40af;
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <a href="{{ route('customers.index') }}" class="back">
        ← Back to Customers
    </a>

    <h1>Edit Customer</h1>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customers.update', $customer->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label>First Name *</label>
            <input type="text" name="first_name"
                value="{{ old('first_name', $customer->first_name) }}" required>
        </div>

        <div class="form-group">
            <label>Last Name *</label>
            <input type="text" name="last_name"
                value="{{ old('last_name', $customer->last_name) }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email"
                value="{{ old('email', $customer->email) }}">
        </div>

        <div class="form-group">
            <label>Phone Number *</label>
            <input type="text" name="phone"
                value="{{ old('phone', $customer->phone) }}" required>
        </div>

        <div class="form-group">
            <label>Date of Birth</label>
            <input type="date" name="date_of_birth"
                value="{{ old('date_of_birth', $customer->date_of_birth) }}">
        </div>

        <div class="form-group">
            <label>Gender</label>
            <select name="gender">
                <option value="">Select Gender</option>
                <option value="Male" {{ old('gender', $customer->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender', $customer->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ old('gender', $customer->gender) == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div class="form-group">
            <label>Address</label>
            <textarea name="address" rows="3">{{ old('address', $customer->address) }}</textarea>
        </div>

        <div class="form-group">
            <label>City</label>
            <input type="text" name="city"
                value="{{ old('city', $customer->city) }}">
        </div>

        <div class="form-group">
            <label>Occupation</label>
            <input type="text" name="occupation"
                value="{{ old('occupation', $customer->occupation) }}">
        </div>

        <button type="submit">Update Customer</button>

    </form>

</div>

</body>
</html>
