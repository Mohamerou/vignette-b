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

	<div class="container col-8 border-top border-primary py-3">
		<div class="alert alert-warning" role="alert">
		  <h4>Notice:</h4> Vous allez initier un transfert de propriete sur l'engin aux caracteristiques suivants
		  <p>Marque: <span class="font-weight-bold">{{ $data['marque'] }}</span></p> 
		  <p>Type:  <span class="font-weight-bold">{{ $data['type'] }}</span></p> 
		  <p>CHASSIE: <span class="font-weight-bold">{{ $data['chassie'] }}</span></p> 
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
		    <label for="newOwnerPhone" class="form-label font-weight-bold">Contact du nouveau Proprietaire</label>
		    <input required name="newOwnerPhone" type="number" class="form-control" id="newOwnerPhone">
		  </div>

		  <input hidden value="{{ $data['enginId'] }}" name="enginId" type="text" class="form-control">


		  <div class="text-center">
		  	<button type="submit" class="btn btn-primary">VALIDER&#8594;</button>
		  </div>
		</form>
	</div>
@endsection