@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Forgot Password</h2>
    <form method="POST" action="{{ route('auth.sendOtp') }}">
        @csrf
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Send OTP</button>
    </form>
</div>
@endsection
