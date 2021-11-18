@extends('layouts.app')

@section('content')
	<div class="container col-8 border-top border-primary py-3">
		<div class="alert alert-info" role="alert">
		  <h4>Notice:</h4> Vous demandez une vignette de moto dont la capacité est comprise entre 51 - 125 CM<sup>3</sup>.
		  <p>Le tarif appliqué est de <span class="font-weight-bold">6 000 FCFA</span></p> 
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
		<form method="POST" action="{{ route('user.storeEngin') }}" enctype="multipart/form-data">
			@csrf
			@if(Session::has('error'))

                <p class="alert
                {{ Session::get('alert-class', 'alert-danger') }}">{{Session::get('error') }}</p>

            @endif

		  <div class="mb-3">
		    <label for="marque" class="form-label font-weight-bold">Marque</label>
		    <select name="marque" id="marque" class="form-control" required id="marque">
		    	<option value="">Selectionner</option>
		    	@foreach($marques as $marque)
		    		<option value="{{ $marque->name }}">{{ $marque->name }}</option>
		    	@endforeach
		    </select>
		  </div>
		  <div class="mb-3">
		    <label for="modele" class="form-label font-weight-bold">Modèle</label>
		    <input required name="modele" type="modele" class="form-control" id="modele">
		  </div>
		  <div class="mb-3">
		    <label for="chassie" class="form-label font-weight-bold">Chassie</label>
		    <input required name="chassie" type="text" class="form-control" id="chassie">
		  </div>
		  <div class="mb-3">
		    <label for="disabledTextInput" class="form-label font-weight-bold">Capacité Moteur</label>
		    <input disabled value="51-125 CM3" name="uiDescription" type="text" class="form-control" id="disabledTextInput">
		  </div>

		  <input hidden value="moto51-125" name="puissanceFiscale" type="text" class="form-control">

		  <div class="mb-3">
		    <label for="Tarif" class="form-label font-weight-bold">Tarif</label>
		    <input disabled value="6000" name="tarif" type="number" class="form-control" id="Tarif" aria-describedby="tarifHelpBlock">
		    <div id="tarifHelpBlock" class="form-text">
			  		Montant de la transaction.
			</div>
		  </div>

		  <input hidden value="6000" name="tarif" type="text" class="form-control">

		  <div class="mb-3">
		    <label for="documentJustificatif" class="form-label font-weight-bold">Facture / Document justificatif</label>
		    <input required  name="documentJustificatif" type="file" class="form-control" id="documentJustificatif">
		  </div>


		  <div class="mb-3">
		    <label for="mairie" class="form-label font-weight-bold">Mairie</label>
		    <select name="mairie" id="marque" class="form-control" required id="mairie" aria-descriptedby="mairieHelpBlock">
		    	<option value="">Selectionner</option>
		    	@foreach($mairies as $mairie)
		    		<option value="{{ $mairie->code }}">{{ $mairie->name }}</option>
		    	@endforeach
		    </select>
		    <div id="mairieHelpBlock" class="form-text">
			  		Votre localité / Commune
			</div>
		  </div>

		  <div class="text-center">
		  	<button type="submit" class="btn btn-primary">Continuer&#8594;</button>
		  </div>
		</form>
	</div>
@endsection