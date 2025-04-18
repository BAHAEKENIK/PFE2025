@extends('layouts.app')

@section('content')
    <h1>Welcome Admin, {{ Auth::user()->name }}</h1>
    <p>Your email is: {{ Auth::user()->email }}</p>
    <a href="{{ route('logout') }}">Logout</a>
@endsection
