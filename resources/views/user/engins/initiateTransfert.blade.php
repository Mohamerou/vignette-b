@extends('layouts.app')

@section('content')

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

    
@can('user')
<div class="nav-scroller bg-white shadow-sm justify-content-center">
	<nav class="nav nav-underline" aria-label="Secondary navigation">
		<a class="nav-link active" aria-current="page" href="{{ route('home') }}">Tableau de bord</a>
		<a class="nav-link active" aria-current="page" href="#">|</a>
		<a class="nav-link" href="{{ route('engins.index') }}">
			Mes vignettes
		</a>
		<a class="nav-link active" aria-current="page" href="#">|</a>
		<a class="nav-link" href="{{ route('initiateTransfert') }}">
			Initier le transfere de propriete d'un engin
		</a>
	</nav>
</div>
@endcan

	<div class="container col-8 border-top border-primary py-3">
		<div class="alert alert-info" role="alert">
		  <h4>Notice:</h4> Vous allez initier une demande de transfert de propriete d'engin !
		</div>
		@if(Session::has('error'))

            <p class="alert
            {{ Session::get('alert-class', 'alert-danger') }}">{{Session::get('error') }}</p>

        @endif

        @if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif
		<form method="POST" action="{{ route('newTransfert') }}">
			@csrf
			@if(Session::has('error'))

                <p class="alert
                {{ Session::get('alert-class', 'alert-danger') }}">{{Session::get('error') }}</p>

            @endif
			<div class="mb-3">
			  <label for="oldOwnerPhone" class="form-label font-weight-bold">Contact de l'ancien Proprietaire</label>
			  <input required name="oldOwnerPhone" type="number" class="form-control" id="oldOwnerPhone">
			</div>
			<div class="mb-3">
			  <label for="chassie" class="form-label font-weight-bold">N<sup>o</sup> de CHASSIE</label>
			  <input required name="chassie" type="text" class="form-control" id="chassie">
			</div>

		  <div class="text-center">
		  	<button type="submit" class="btn btn-primary">VALIDER&#8594;</button>
		  </div>
		</form>
	</div>
@endsection