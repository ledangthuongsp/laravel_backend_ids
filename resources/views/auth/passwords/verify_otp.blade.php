@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Verify OTP</h2>
    <form method="POST" action="{{ route('auth.verifyOtp') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="otp">OTP Code</label>
            <input type="text" id="otp" name="otp" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Verify OTP</button>
    </form>
</div>
@endsection
