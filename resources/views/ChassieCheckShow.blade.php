@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <h4 class="card-header">{{ __('Vérification par No-Chassie') }}</h4>

                <div class="card-body">
                    @if(Session::has('error'))

                        <p class="alert
                        {{ Session::get('alert-class', 'alert-danger') }}">{{Session::get('error') }}</p>

                    @endif
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Un nouveau code de confirmation a été envoyé à votre numero.') }}
                        </div>
                    @endif
                    <form class="text-center" method="POST" action="{{route('ChassieCheck')}}">
                    	@csrf
					  <div class="mb-3">
					    <input type="text" class="form-control" id="code" name="chassie" aria-describedby="chassieHelp">
					    <div id="chassieHelp" class="form-text">{{__('Numero Chassie')}}</div>
					  </div>
					  <button type="submit" class="btn btn-primary">{{__('Verifier')}}</button>
					</form>
                    <div id="codeHelp" class="form-text">{{__("C'est facile, c'est ikaVignetti,")}}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection