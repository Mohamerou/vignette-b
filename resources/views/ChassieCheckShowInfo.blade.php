@extends('layouts.app')

@section('content')
	<section class="py-2 text-center container">
	
	    <div class="row py-lg-5">
	      <div class="col-lg-6 col-md-8 mx-auto">
	        <h1 class="fw-light bg-light">VERIFICATION</h1>
	      </div>
	    </div>
	 </section>

	<div class="container mt-5">
		<div class="row row-cols-1 row-cols-md-2 g-4">
		  <div class="col">
		    <div class="card mt-5">
		    	<h4 class="alert-heading text-center py-1">USAGER</h4>
		      <img src="{{ ('https://ikavignetti-assets.s3.us-east-2.amazonaws.com/'.$usager->idCard) }}" class="card-img-top-examine" alt="Carte d'identité">
		      <div class="card-body text-center">
		        
		        <h4 class="card-title">{{ $usager->lastname }}</h4>
		        <h4 class="card-title">{{ $usager->firstname }}</h4>
		        <h4 class="card-title">{{ $usager->address }}</h4>
		      </div>
		    </div>
		  </div>
		  <div class="col">
		    <div class="card">
		        <h4 class="alert-heading text-center py-1">ENGIN</h4>
		      <img src="{{ ('https://ikavignetti-assets.s3.us-east-2.amazonaws.com/'.$engin->documentJustificatif) }}" class="card-img-top-examine" alt="Piece justificatrice de l'appartenance de l'engin">
		      <div class="card-body text-center">
		        <h4 class="card-title">Expire le {{ $vignette->expired_at }}</h4>
		        <h4 class="card-title">{{ $engin->marque }}</h4>
		        <h4 class="card-title">{{ $engin->modele }}</h4>
		        <h4 class="card-title">{{ $engin->chassie }}</h4>
		      </div>
		    </div>
		  </div>
		</div>
	</div>

@endsection