@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Code de confirmation') }}</div>

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
                    <form method="POST" action="{{route('post-verify')}}">
                    	@csrf
					  <div class="mb-3">
					    <input type="text" class="form-control" id="code" name="code" aria-describedby="codeHelp">
                        <input type="text" hidden class="form-control" id="phone" name="phone" aria-describedby="phoneHelp" value="{{ $phone }}">
					    <div id="codeHelp" class="form-text">{{__('Saisissez le code de confirmation.')}}</div>
					  </div>
					  <button type="submit" class="btn btn-primary">{{__('Verifier')}}</button>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection