@extends('layouts.app')

@section('content')
  

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 mt-lg-5">
            <div class="card text-center">
                <div class="card-header bg-white mt-5"><h4>{{ __('Inscription') }}</h4></div>

                <div class="card-body">
                    <div class="row justify-content-center">
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <div class="alert alert-class alert-danger text-center col-6">

                                {{$error}}<br>
                            </div>
                            @endforeach
                        @endif
                        @if(Session::has('success'))

                            <div class="alert
                            {{ Session::get('alert-class', 'alert-success') }} text-center col-md-8">

                                    {{Session::get('success') }}
                            </div>

                        @endif

                       @if(Session::has('error'))

                            <div class="alert
                            {{ Session::get('alert-class', 'alert-danger') }} text-center col-8">

                                {{Session::get('error') }}
                            </div>

                        @endif
                    </div>

                    <form method="POST" action="{{ route('postInscription') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="lastname" class="col-md-4 col-form-label text-md-left">{{ __('Nom') }}</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-left">{{ __('Prenom') }}</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-left">{{ __('Vous êtes?') }}</label>

                            <div class="col-md-6">
                                <select class="form-control" name="gender" required value={{ old('genre')}}>
                                    <option value="">Genre</option>
                                    <option value="1">Homme</option>
                                    <option value="0">Femme</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-left">{{ __('Addresse') }}</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address" autofocus>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-left">{{ __('Pièce d\'identité') }}</label>

                            <div class="col-md-6">
                                <input id="idCard" type="file" class="form-control @error('address') is-invalid @enderror" name="idCard" value="{{ old('idCard') }}" required autofocus>

                                @error('idCard')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-left">{{ __('Telephone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-left">{{ __('Mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-left">{{ __('Confirmer Mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Continuer') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
