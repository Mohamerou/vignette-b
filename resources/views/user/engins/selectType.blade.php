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
	
	<div class="container">
	        @if(Session::has('unknown'))

	            <div class="alert
	            {{ Session::get('alert-class', 'alert-danger') }} text-center col-md-6">{{Session::get('unknown') }}</div>

	        @endif
	        
		<div class="row row-cols-1 row-cols-md-3 g-4">
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/moto51-125.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">51 - 125 CM<sup>3</sup></h5>
		        <h5 class="card-title font-weight-bold">Tarif: 6 000 FCFA</h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'moto51-125']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/moto125plus.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">125 CM<sup>3</sup> - PLUS</h5>
		        <h5 class="card-title font-weight-bold">Tarif: 12 000 FCFA</h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'moto125plus']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/tricycle125.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">125 CM<sup>3</sup></h5>
		        <h5 class="card-title font-weight-bold">Tarif: 33 000 FCFA</h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'tricycle125']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/tricycle150.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">150 CM<sup>3</sup></h5>
		        <h5 class="card-title font-weight-bold">Tarif: 46 000 FCFA</h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'tricycle150']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/tricycle175-200.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">175 - 200 CM<sup>3</sup></h5>
		        <h5 class="card-title font-weight-bold">Tarif: 60 000 FCFA</h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'tricycle175-200']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/auto2-6cv.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">2 - 6 CHEVAUX</h5>
		        <h5 class="card-title font-weight-bold">Tarif: 7 000 FCFA<sup>3</sup></h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'auto2-6cv']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/auto7-9cv.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">7 - 9 CHEVAUX</h5>
		        <h5 class="card-title font-weight-bold">Tarif: 13 000 FCFA</h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'auto7-9cv']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/auto10-14cv.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">10 - 14 CHEVAUX</h5>
		        <h5 class="card-title font-weight-bold">Tarif: 32 000 FCFA</h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'auto10-14cv']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/auto15-19cv.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">15 à 19 CHEVAUX</h5>
		        <h5 class="card-title font-weight-bold">Tarif: 50 000 FCFA</h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'auto15-19cv']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/auto20pluscv.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">20 CHEVAUX - PLUS</h5>
		        <h5 class="card-title font-weight-bold">Tarif: 75 000 FCFA</h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'auto20pluscv']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/camion10t.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">Camion 10T</h5>
		        <h5 class="card-title font-weight-bold">Age: -10 ans &#8594; Tarif: 188 600 FCFA</h5>
		        <h5 class="card-title font-weight-bold">Age: +10 ans &#8594; Tarif: 133 400 FCFA</h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'camion10t']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/camion15t.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">Camion 15T</h5>
		        <h5 class="card-title font-weight-bold">Age: -10 ans &#8594; Tarif: 243 800 FCFA</h5>
		        <h5 class="card-title font-weight-bold">Age: +10 ans &#8594; Tarif: 170 200 FCFA</h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'camion15t']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/camion24t.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">Camion 24T - PLUS</h5>
		        <h5 class="card-title font-weight-bold">Age: -10 ans &#8594; Tarif: 414 000 FCFA</h5>
		        <h5 class="card-title font-weight-bold">Age: +10 ans &#8594; Tarif: 289 800 FCFA</h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'camion24t']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/transport-public-16p.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">Transport Publique 16 Places</h5>
		        <h5 class="card-title font-weight-bold">Age: -2 ans &#8594; Tarif: 128 000 FCFA</h5>
		        <h5 class="card-title font-weight-bold">Age: +2 ans &#8594; Tarif:  88 000 FCFA</h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'transport-public-16p']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/transport-public-17-35p.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">Transport Publique 17 - 35 Places</h5>
		        <h5 class="card-title font-weight-bold">Age: -2 ans &#8594; Tarif: 168 000 FCFA</h5>
		        <h5 class="card-title font-weight-bold">Age: +2 ans &#8594; Tarif: 116 000 FCFA</h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'transport-public-17-35p']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/transport-public-36-45p.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">Transport Publique 36 - 45 Places</h5>
		        <h5 class="card-title font-weight-bold">Age: -2 ans &#8594; Tarif: 253 000 FCFA</h5>
		        <h5 class="card-title font-weight-bold">Age: +2 ans &#8594; Tarif: 174 800 FCFA</h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'transport-public-36-45p']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		  <div class="col py-2">
		    <div class="card h-100 text-center">
		      <img src="{{ asset('engins/transport-public-45plusp.png') }}" class="card-img-top img-thumbnail" alt="moto51-125">
		      <div class="card-body">
		        <h5 class="card-title font-weight-bold">Transport Publique 45 Places - PLUS</h5>
		        <h5 class="card-title font-weight-bold">Age: -2 ans &#8594; Tarif: 326 600 FCFA</h5>
		        <h5 class="card-title font-weight-bold">Age: +2 ans &#8594; Tarif: 230 000 FCFA</h5>
		      </div>
		      <form method="GET" action="{{ route('user.createEngin',['type' => 'transport-public-45plusp']) }}">
		      	@csrf
		        <div class="card-footer">
			        <button class="btn btn-success">ACHETER &#8594;</button>
			     </div>
		        </form>
		    </div>
		  </div>
		</div>
	</div>
@endsection