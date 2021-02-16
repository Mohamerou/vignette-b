@extends('layouts.app')

@section('content')

	<section class="py-2 text-center container">
	    <div class="row py-lg-3">
	      <div class="col-lg-6 col-md-8 mx-auto">
	      	@if(Session::has('message'))
	        <p class="alert
	        {{ Session::get('alert-class', 'alert-info') }} tex-center">{{Session::get('message') }}</p>

	         @endif

	         @if(Session::has('declared'))

	            <p class="alert
	            {{ Session::get('alert-class', 'alert-info') }} tex-center">{{Session::get('declared') }}</p>

	         @endif

	         @if(Session::has('error'))

	            <p class="alert
	            {{ Session::get('alert-class', 'alert-danger') }} tex-center">{{Session::get('error') }}</p>

	         @endif

	         @if(Session::has('annuler'))

	            <p class="alert
	            {{ Session::get('alert-class', 'alert-success') }} tex-center">{{Session::get('annuler') }}</p>

	         @endif

	         @if(Session::has('renouveller'))

	            <p class="alert
	            {{ Session::get('alert-class', 'alert-info') }} tex-center">{{Session::get('renouveller') }}</p>

	        @endif
	        <h1 class="fw-light">Mes vignettes</h1>
	        <p class="lead text-muted">Retrouver la liste de vos vignettes.</p>
	        <p>
	          <a href="{{ route('user.selectEnginType') }}" class="btn btn-outline-primary my-2">Acheter une vignette</a>
	          {{-- <a href="#" class="btn btn-secondary my-2">Secondary action</a> --}}
	        </p>
	      </div>
	    </div>
	</section>


	@if(!$empty)	
		@if(!empty($up_to_date_vignettes))
			<section class="py-1 text-center container">
				<hr>
				<h4 class="fw-light text-left">VIGNETTES A JOUR</h4>
				<hr>
				<div class="row row-cols-1 row-cols-md-3 g-4">
					@foreach($up_to_date_vignettes  as $up_todate_vignette)
                  		@foreach($up_to_date_engins as $up_todate_engin)
                  			@if($up_todate_vignette->enginId == $up_todate_engin->id)
							  	<div class="col">
							    	<div class="card mb-3 text-center">
							      		<img src="{{ asset('storage/'.$up_todate_vignette->qr) }}" alt="vignette QR Code" class="card-img-top">
							      		<div class="card-body">
							      			<h5 class="card-title">{{ $up_todate_engin->marque }}</h5>
							      			<h5 class="card-title">{{ $up_todate_engin->modele }}</h5>
							      			<h5 class="card-title">{{ $up_todate_engin->chassie }}</h5>
							      		</div>
							      		<div class="card-footer">
							      			@if($up_todate_engin->signaler_perdue != 0)
			                                  <form method="POST" action="{{ route('annuler_declaration', [$userId, $up_todate_vignette->id, $up_todate_engin->id]) }}">
			                                    @csrf
			                                    <button type="submit" class="btn btn-danger btn-lg btn-block py-2 my-2">&#9888; ANNULER LA DECLARATION</button>
			                                  </form>
			                                @else
			                                  <form method="POST" action="{{ route('declaration_de_perte', [$userId, $up_todate_vignette->id, $up_todate_engin->id]) }}">
			                                    @csrf
			                                    <button type="submit" class="btn btn-danger btn-lg btn-block py-2 my-2">DECLARER UN VOL D'ENGIN</button>
			                                  </form>
			                                @endif
								        	<form method="POST" action="{{ route('downloadQr', [$up_todate_vignette->qr_download_path]) }}">
								        		<button class="btn btn-primary btn-lg btn-block py-2 my-2">Telecharger QR</button>
								        	</form>
								      	</div>
							    	</div>
							    </div>
						    @endif
						@endforeach
					@endforeach
				</div>
				  
			</section>
		@endif

		@if(!empty($out_dated_vignettes))
			<section class="py-1 text-center container">
				<hr>
				<h4 class="fw-light text-right">VIGNETTES EXPIREES</h4>
				<div class="row row-cols-1 row-cols-md-3 g-4">
					@foreach($out_dated_vignettes  as $outdated_vignette)
                  		@foreach($out_dated_engins as $outdated_engin)
                  			@if($outdated_vignette->enginId == $outdated_engin->id)
							  	<div class="col">
							    	<div class="card mb-3 text-center">
							      		<img src="{{ asset('storage/'.$up_todate_vignette->qr) }}" alt="vignette QR Code" class="card-img-top">
							      		<div class="card-body">
						        			<h5 class="card-title">Card title</h5>
							        		<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
							      		</div>
							      		<div class="card-footer">
							      			@if($up_todate_engin->signaler_perdue != 0)
			                                  <form method="POST" action="{{ route('annuler_declaration', [$userId, $outdated_vignette->id, $outdated_engin->id]) }}">
			                                    @csrf
			                                    <button type="submit" class="btn btn-danger">&#9888; ANNULER LA DECLARATION</button>
			                                  </form>
			                                @else
			                                  <form method="POST" action="{{ route('declaration_de_perte', [$userId, $outdated_vignette->id, $outdated_engin->id]) }}">
			                                    @csrf
			                                    <button type="submit" class="btn btn-danger btn-lg btn-block py-2 my-2">DECLARER UN VOL D'ENGIN</button>
			                                  </form>
			                                @endif
								        	<form method="GET" action="{{ route('downloadQr', [$outdated_vignette->qr_download_path]) }}">
								        		<button class="btn btn-primary btn-lg btn-block py-2 my-2">Telecharger QR</button>
								        	</form>
								      	</div>
							    	</div>
							    </div>
						    @endif
						@endforeach
					@endforeach
				</div>
				  
			</section>
		@endif

		@if(!empty($awaiting_confirmations))
			<section class="py-5 text-center container">
				<hr>
	    		<h4 class="fw-light text-right">VIGNETTES EN ATTENTE DE CONFIRMATION</h4>
            	<table class="table table-stripped table-hover mt-3">
				  <thead>
				    <tr>
				      <th scope="col">MARQUE</th>
				      <th scope="col">MODELE</th>
				      <th scope="col">N<sup>o</sup> CHASSIE</th>
				      <th scope="col">ETAT</th>
				    </tr>
				  </thead>
				  <tbody>
				  		@foreach($awaiting_confirmations as $await_engin)
						    <tr>
						      <td>{{ $await_engin->marque }}</td>
						      <td>{{ $await_engin->modele }}</td>
						      <td>{{ $await_engin->chassie }}</td>
						      <td><button class="alert alert-info text-center" disabled>ATTENTE DE COFIRMATION</button></td>
						    </tr>
            			@endforeach
            		</tbody>
				</table>
			</section>
		@endif


	@else
	@endif


	<section class="py-5 text-center container">

@endsection