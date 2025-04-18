@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" required>
        </div>

        <div>
            <button type="submit">Send Reset Link</button>
        </div>
    </form>
@endsection
