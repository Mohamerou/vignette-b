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

    <div class="row g-5 ">
      <div class="col-md-5 col-md-7 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Infos Engins</span>
        </h4>
        <div class="card">
          
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0 " >
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>N°</th>
                  <th>Marque</th>
                  <th>Type</th>
                  <th>Chassie</th>
                  <th>Cylindre</th>
                  <th>Montant</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>{{ $data['marque'] }}</td>
                  <td>{{ $data['modele'] }}</td>
                  <td><span class="tag tag-success">{{ $data['chassie'] }}</span></td>
                  <td>{{ $data['cylindre'] }}</td>
                  <td class="text-danger">{{ $data['amount'] }} FCFA</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>

      </div>
      <div class="col-md-5 ">
        <h4 class="text-primary mb-3">Infos Entreprise</h4>
        <form class="needs-validation" novalidate action="{{ route('salesStepTwo') }}" method="POST">
            @csrf
          <div class="row g-3">
            <div class="col-12">
              <label for="firstName" class="form-label">Nom</label>
              <input name="firstname" type="text" class="form-control" id="firstName" placeholder="" value="{{ $data['firstname'] }}" required>
              <div class="invalid-feedback">
                Valid first name is required.
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
          </div>

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