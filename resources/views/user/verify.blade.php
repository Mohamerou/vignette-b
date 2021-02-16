@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <h4 class="card-header">{{ __('Code de confirmation') }}</h4>

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
                    <form class="text-center" method="POST" action="{{route('post-verify')}}">
                    	@csrf
					  <div class="mb-3">
					    <input type="text" class="form-control" id="code" name="code" aria-describedby="codeHelp">
                        <input type="text" hidden class="form-control" id="phone" name="phone" aria-describedby="phoneHelp" value="{{ $phone }}">
					    <div id="codeHelp" class="form-text">{{__('Saisissez le code de confirmation.')}}</div>
					  </div>
					  <button type="submit" class="btn btn-primary">{{__('Verifier')}}</button>
					</form>
                    <div id="codeHelp" class="form-text">{{__("Vous n'avez pas reçu le code?")}} <a href="{{ route('resend_code', $phone) }}">Réenvoyer</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection