<style>
  .pieceStyle1{
    width: 200px;
  }

  .pieceStyle2{
    width: 200px;
  }
  .pieceStyle1:hover{
  transform: translateX(50px) !important;
  width: 600px;
  position: relative;
  z-index: 1000;
  }
  .pieceStyle2:hover{
  transform: translateX(-350px) !important;
  width: 600px;
  position: relative;
  z-index: 1000;
  }
  
</style>
@extends('layouts.checkout')

@section('content')
<div class="content-wrapper">

  
<section class="content mx-3">
  <main>
    <div class="py-5 text-center">
      <img class="d-block mx-auto mb-4" src="{{ asset('/images/logo.png') }}" alt="" width="72" height="72">
      <h2>OPERATION CAISSE</h2>
      <p class="lead"></p>
    </div>
    <div class="row g-5 mb-5 justify-content-center">
      <div class="col-md-5 col-md-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Facture / Vignette Engin</span>
        </h4>
        <div >
        <img class="pieceStyle2" src="{{ asset('storage/'.$data['documentJustificatif']) }}" alt="">
      </div>
      </div>
      <div class="col-md-5 col-lg-6">
        <h4 class="text-primary mb-3">Pièce d'identité Usager</h4>
        <div >
          <img class="pieceStyle1" src="{{ asset('storage/'.$data['idcard']) }}" alt="">
        </div>
      </div>
    </div>
    <div class="row g-5 ">
      <div class="col-md-4 col-md-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Infos Engin</span>
        </h4>
        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Marque</h6>
              <small class="text-muted"></small>
            </div>
            <span class="text-muted" style="text-trandform:uppercase;">{{ $data['marque'] }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Type</h6>
              <small class="text-muted"></small>
            </div>
            <span class="text-muted">{{ $data['modele'] }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Chassie</h6>
              <small class="text-muted"></small>
            </div>
            <span class="text-muted">{{ $data['chassie'] }}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Cylindre</h6>
              <small class="text-muted"></small>
            </div>
            <span class="text-muted">{{ $data['cylindre'] }} CM<sup>3</sup> </span>
          </li>
          <li class="list-group-item d-flex justify-content-between">
            <h6>Montant</h6>
            <strong class="text-danger">{{ $data['amount'] }} FCFA</strong>
          </li>
        </ul>

      </div>
      <div class="col-md-7 col-lg-8">
        <h4 class="text-primary mb-3">Infos Usager</h4>
        <form class="needs-validation" novalidate action="{{ route('salesStepTwo') }}" method="POST">
            @csrf
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">Prenom</label>
              <input name="firstname" type="text" class="form-control" id="firstName" placeholder="" value="{{ $data['firstname'] }}" required>
              <div class="invalid-feedback">
                Valid first name is required.
              </div>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Nom</label>
              <input name="lastname" type="text" class="form-control" id="lastName" placeholder="" value="{{ $data['lastname'] }}" required>
              <div class="invalid-feedback">
                Valid last name is required.
              </div>
            </div>

            <div class="col-12">
              <label for="phone" class="form-label">Telephone</label>
              <input name="phone" type="text" class="form-control" id="phone" value="{{ $data['phone'] }}" required>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Adresse</span></label>
              <input name="address" type="text" class="form-control" id="address" value="{{ $data['address'] }}" placeholder="Adresse">
            </div>
              <input name="chassie" type="hidden" class="form-control" id="chassie" value="{{ $data['chassie'] }}">
              <input name="amount" type="hidden" class="form-control" id="amount" value="{{ $data['amount'] }}">
              <input name="cylindre" type="hidden" class="form-control" id="cylindre" value="{{ $data['cylindre'] }}">
              <input name="modele" type="hidden" class="form-control" id="modele" value="{{ $data['modele'] }}">
              <input name="marque" type="hidden" class="form-control" id="marque" value="{{ $data['marque'] }}">

         
              <hr class="my-4">

            <button class="w-100 btn btn-primary btn-lg" type="submit">PAYER CACHE</button>
            <hr class="my-4">

            <button class="w-100 btn btn-primary btn-lg" type="button">Payement OM</button>

        </form>
      </div>
    </div>
  </main>
</div>
</section>


    <script src="/docs/5.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

      <script src="form-validation.js"></script>
@endsection