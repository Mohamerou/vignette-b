@extends('layouts.app')

@section('content')
	

	<div class="container">
		@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
	@endif
		<div class="mb-3">
		  	<h3 class="text-center">Provenance de la notification</h3>
		  	<h4 class="text-left">{{ $toBeReadNotification->data['from'] }}</h4>
			<div class="py-5 mx-auto text-left">
			  <label for="contenu" class="form-label"></label>
			  
			  <textarea disabled class="form-control text-center" id="contenu">
			  	{{ $toBeReadNotification->data['note'] }}
			  </textarea>
			</div>
		</div>

	</div>

		
@endsection