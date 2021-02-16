@extends('layouts.app')

@section('content')
	<section class="py-2 text-center container">
	
	    <div class="row py-lg-5">
	      <div class="col-lg-6 col-md-8 mx-auto">
	        <h1 class="fw-light bg-light">Examination de la demande de vignette</h1>
	      </div>
	    </div>
	 </section>

	<div class="container">
		<div class="row row-cols-1 row-cols-md-2 g-4">
		  <div class="col">
		    <div class="card">
		      <img src="{{ Storage::disk('s3')->url($usager->idCard) }}" class="card-img-top-examine" alt="Carte d'identité">
		      <div class="card-body text-center">
		        <h5 class="card-text">DEMANDEUR</h5>
		        <h4 class="card-title">{{ $usager->lastname }}</h4>
		        <h4 class="card-title">{{ $usager->firstname }}</h4>
		        <h4 class="card-title">{{ $usager->address }}</h4>
		      </div>
		    </div>
		  </div>
		  <div class="col">
		    <div class="card">
		      <img src="{{ Storage::disk('s3')->url($engin->documentJustificatif) }}" class="card-img-top-examine" alt="Piece justificatrice de l'appartenance de l'engin">
		      <div class="card-body text-center">
		        <h5 class="card-text">ENGIN</h5>
		        <h4 class="card-title">{{ $engin->marque }}</h4>
		        <h4 class="card-title">{{ $engin->modele }}</h4>
		        <h4 class="card-title">{{ $engin->chassie }}</h4>
		      </div>
		    </div>
		  </div>
		</div>
	</div>

	<section class="py-1 text-center container bg-light">
	    <div class="row py-lg-5">
	      <div class="col-lg-6 col-md-8 mx-auto">
	        <h1 class="fw-light">VERDICTE</h1>
	        <p class="col-md-6">
	        	<form method="POST" action="{{ route('validerDemande', [$engin->id, $notificationId, $userId, $demandeTrackId] ) }}">
	        		@csrf
	        		<button class="btn btn-primary btn-lg btn-block py-2 my-2" type="submit">VALIDER</button>
	        	</form>
	        	<form method="POST" action="{{ route('validerDemande', [$engin->id, $notificationId, $userId, $demandeTrackId] ) }}">
	        		@csrf
	        		<button class="btn btn-danger btn-lg btn-block py-2 my-2" type="submit">REJECTER</button>
	        	</form>
	        </p>
	      </div>
	    </div>
	 </section>

@endsection