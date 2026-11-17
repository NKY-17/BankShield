
@php
    $isEdit = isset($receiver) && $receiver->exists;
@endphp

<div style="margin-top: 15px;">

    <label>Receiver Name:</label><br>
    <input type="text"
           name="receiver_name"
           value="{{ old('receiver_name', $receiver->receiver_name ?? '') }}"
           required>
    @error('receiver_name')
        <p style="color:red">{{ $message }}</p>
    @enderror

</div>

<div style="margin-top: 15px;">

    <label>Bank Name:</label><br>
    <input type="text"
           name="bank_name"
           value="{{ old('bank_name', $receiver->bank_name ?? '') }}"
           required>
    @error('bank_name')
        <p style="color:red">{{ $message }}</p>
    @enderror

</div>

<div style="margin-top: 15px;">

    <label>Account Number:</label><br>
    <input type="text"
           name="account_number"
           value="{{ old('account_number') }}"
           {{ $isEdit ? '' : 'required' }}
           placeholder="{{ $isEdit ? 'Leave blank to keep current account number' : 'Enter account number' }}">
    @error('account_number')
        <p style="color:red">{{ $message }}</p>
    @enderror

</div>

<div style="margin-top: 15px;">

    <label>Nickname (Optional):</label><br>
    <input type="text"
           name="nickname"
           value="{{ old('nickname', $receiver->nickname ?? '') }}">
    @error('nickname')
        <p style="color:red">{{ $message }}</p>
    @enderror

</div>
