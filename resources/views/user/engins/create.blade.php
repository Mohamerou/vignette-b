@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="flex justify-content-center">
	        @if(Session::has('success'))

	            <div class="alert
	            {{ Session::get('alert-class', 'alert-success') }} text-center col-md-6">{{Session::get('success') }}</div>

	        @endif

	       @if(Session::has('error'))

	            <div class="alert
	            {{ Session::get('alert-class', 'alert-danger') }} text-center col-6">{{Session::get('error') }}</div>

	        @endif
	    </div>
                        
		<div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
		    <img class="me-3" src="/docs/5.0/assets/brand/bootstrap-logo-white.svg" alt="" width="48" height="38">
		    <div class="lh-1">
		      <h1 class="h6 mb-0 text-white lh-1">Bootstrap</h1>
		      <small>Since 2011</small>
		    </div>
		 </div>
		<form>
		  <div class="mb-3">
		    <label for="type" class="form-label">Type Engin</label>
		    <select class="form-control" id="type">
		    	<option value="">Sélectionner</option>
		    	<option value="auto">Auto</option>
		    	<option value="moto">Moto</option>
		    </select>
		  </div>
		  
		  <div class="mb-3">
		    <label for="type" class="form-label">Type Engin</label>
		    <select class="form-control" id="type">
		    	<option value="">Sélectionner</option>
		    	<option value="auto">Auto</option>
		    	<option value="moto">Moto</option>
		    </select>
		  </div>
		  <div class="mb-3">
		    <label for="type" class="form-label">Type Engin</label>
		    <select class="form-control" id="type">
		    	<option value="">Sélectionner</option>
		    	<option value="auto">Auto</option>
		    	<option value="moto">Moto</option>
		    </select>
		  </div>
		  <div class="mb-3">
		    <label for="type" class="form-label">Type Engin</label>
		    <select class="form-control" id="type">
		    	<option value="">Sélectionner</option>
		    	<option value="auto">Auto</option>
		    	<option value="moto">Moto</option>
		    </select>
		  </div>

		  <div class="form-group">
			<label for="cylindre" class="form-label font-weight-bold">Cylindre</label>
			<select name="cylindre" id="cylindre" class="form-control" required id="cylindre">
				<option value="">Selectionner</option>
					<option value="+125">+125 cm<sup>3</sup> (12 000 FCFA)</option>
					<option value="125">125 cm<sup>3</sup> (6 000 FCFA)</option>
					<option value="51">51 cm<sup>3</sup> (3 000 FCFA)</option>
					<option value="0">0 cm<sup>3</sup> (1 500 FCFA)</option>
			</select>
		  </div>
		
		  <div class="mb-3">
		    <label for="exampleInputPassword1" class="form-label">Password</label>
		    <input type="password" class="form-control" id="exampleInputPassword1">
		  </div>
		  <div class="mb-3 form-check">
		    <input type="checkbox" class="form-check-input" id="exampleCheck1">
		    <label class="form-check-label" for="exampleCheck1">Check me out</label>
		  </div>
		  <button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>	
@endsection