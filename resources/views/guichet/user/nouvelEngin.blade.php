@extends ('layouts.admin')

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Enrollement Engin</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admin-dashboard">Accueil</a></li>
              <li class="breadcrumb-item active">Enrollement</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
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

      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Infos Engin</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('guichet.user.engin.nouvel.post') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="marque">Marque</label>
                    <input name="marque" type="text" class="form-control" id="marque" placeholder="Marque">
                    <input name="user_id" type="hidden" value="{{ $user_id }}">
                  </div>
                  <div class="form-group">
                    <label for="modele">Type</label>
                    <input name="modele" type="text" class="form-control" id="modele" placeholder="Modele">
                  </div>
                  <div class="form-group">
                    <input name="mairie" type="hidden" class="form-control" id="mairie" value="bko">
                  </div>
                  <div class="form-group">
                    <label for="chassie">chassie</label>
                    <input name="chassie" type="text" class="form-control" id="chassie" placeholder="No Chassie">
                  </div>

                  <div class="form-group">
                    <label for="cylindre" class="form-label font-weight-bold">Cylindre</label>
                    <select name="cylindre" id="cylindre" class="form-control" required id="cylindre">
                        <option value="">Selectionner</option>
                            <option value="+125">+125 cm<sup>3</sup> (12 000 FCFA)</option>
                            <option value="125">51  -  125 cm<sup>3</sup> (6 000 FCFA)</option>
                            <option value="50">1  -  50 cm<sup>3</sup> (3 000 FCFA)</option>
                            <option value="0">0 cm<sup>3</sup> (1 500 FCFA)</option>
                    </select>
                  </div>
                  
                  <div class="form-group">
                    <label for="documentJustificatif">Facture / Ancienne vignette</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input name="documentJustificatif" type="file" class="custom-file-input" id="documentJustificatif">
                        <label  class="custom-file-label" for="documentJustificatif">Choisir un document</label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Valider</button>
                </div>
              </form>
            </div>
            <!-- /.card -->


          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection