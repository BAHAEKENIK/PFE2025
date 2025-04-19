@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tableau de Bord Prestataire</h1>
     @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <p>Bienvenue, {{ Auth::user()->name }}!</p>
    <p>Contenu spécifique pour les prestataires.</p>
</div>
@endsection
