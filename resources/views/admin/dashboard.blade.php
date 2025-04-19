@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tableau de Bord Administrateur</h1>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <p>Bienvenue, {{ Auth::user()->name }}!</p>
    <p>C'est ici que l'administration se passe.</p>

     {{-- Bouton Logout (déjà dans le layout) --}}
    {{-- <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form> --}}
</div>
@endsection
