@extends('layouts.app') {{-- Utilisez votre layout de base --}}

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    {{-- Affichage des erreurs de validation globales --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data"> {{-- N'oubliez pas enctype pour les fichiers --}}
                        @csrf

                        {{-- Name --}}
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Password --}}
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        {{-- Role (Dropdown) --}}
                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Register as') }}</label>
                            <div class="col-md-6">
                                <select id="role" class="form-select @error('role') is-invalid @enderror" name="role" required>
                                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>{{ __('Choose your role...') }}</option>
                                    <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>{{ __('Client') }}</option>
                                    <option value="provider" {{ old('role') == 'provider' ? 'selected' : '' }}>{{ __('Provider') }}</option>
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Phone (Optionnel) --}}
                        <div class="row mb-3">
                            <label for="phone" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }} <small class="text-muted">({{ __('Optional') }})</small></label>
                            <div class="col-md-6">
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="tel">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                         {{-- City (Dropdown - Optionnel) --}}
                        <div class="row mb-3">
                            <label for="city" class="col-md-4 col-form-label text-md-end">{{ __('City') }} <small class="text-muted">({{ __('Optional') }})</small></label>
                            <div class="col-md-6">
                                {{-- Remplacement de l'input par un select --}}
                                <select id="city" class="form-select @error('city') is-invalid @enderror" name="city">
                                    {{-- Option vide pour le caractère optionnel --}}
                                    <option value="" {{ old('city', '') == '' ? 'selected' : '' }}>{{ __('-- Select City (Optional) --') }}</option>

                                    {{-- Boucle sur les villes passées par le contrôleur --}}
                                    @isset($cities) {{-- Vérifie que la variable $cities existe --}}
                                        @foreach ($cities as $cityValue)
                                            <option value="{{ $cityValue }}" {{ old('city') == $cityValue ? 'selected' : '' }}>
                                                {{ $cityValue }}
                                            </option>
                                        @endforeach
                                    @else
                                        {{-- Message si la liste n'est pas disponible (ne devrait pas arriver) --}}
                                        <option value="" disabled>{{ __('City list unavailable') }}</option>
                                    @endisset
                                </select>

                                {{-- Affichage de l'erreur spécifique à la ville --}}
                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Profile Photo (Optionnel) --}}
                        <div class="row mb-3">
                            <label for="profile_photo" class="col-md-4 col-form-label text-md-end">{{ __('Profile Photo') }} <small class="text-muted">({{ __('Optional') }})</small></label>
                            <div class="col-md-6">
                                <input id="profile_photo" type="file" class="form-control @error('profile_photo') is-invalid @enderror" name="profile_photo" accept="image/png, image/jpeg, image/gif">
                                @error('profile_photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Bio (Optionnel) --}}
                         <div class="row mb-3">
                            <label for="bio" class="col-md-4 col-form-label text-md-end">{{ __('Bio') }} <small class="text-muted">({{ __('Optional') }})</small></label>
                            <div class="col-md-6">
                                <textarea id="bio" class="form-control @error('bio') is-invalid @enderror" name="bio" rows="3">{{ old('bio') }}</textarea>
                                @error('bio')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        {{-- Bouton d'enregistrement --}}
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                                <a href="{{ route('login') }}" class="btn btn-link">
                                    {{ __('Already have an account?') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div> {{-- fin card-body --}}
            </div> {{-- fin card --}}
        </div> {{-- fin col-md-8 --}}
    </div> {{-- fin row --}}
</div> {{-- fin container --}}
@endsection
