@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Reset Password - Step 2: Enter Code') }}</div>

                <div class="card-body">
                   @if (session('status'))
                        <div class="alert alert-info" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                     @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                             @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif

                    <p>Un code a été envoyé à votre adresse email. Veuillez le saisir ci-dessous.</p>

                    <form method="POST" action="{{ route('password.code.verify') }}">
                        @csrf

                        {{-- Champ caché pour l'email (récupéré depuis la session dans le contrôleur) --}}
                        {{-- Ou on pourrait l'afficher si on veut --}}

                        <div class="mb-3">
                            <label for="code" class="form-label">{{ __('Reset Code') }}</label>
                            <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" required autofocus>
                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Verify Code') }}
                            </button>
                             <a href="{{ route('password.request') }}" class="btn btn-link">
                                {{ __('Resend Code?') }} {{-- Ou retour au login --}}
                            </a>
                             <a href="{{ route('login') }}" class="btn btn-link">
                                {{ __('Back to Login') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
