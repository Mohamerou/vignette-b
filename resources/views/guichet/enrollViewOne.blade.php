@extends ('layouts.admin')

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Enrollement Usager</h1>
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
                <h3 class="card-title">Infos Usagers</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('postStepOne') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="lastname">Nom</label>
                    <input name="lastname" type="text" class="form-control" id="lastname" placeholder="Nom">
                  </div>
                  <div class="form-group">
                    <label for="firstname">Prénom</label>
                    <input name="firstname" type="text" class="form-control" id="firstname" placeholder="Prénom">
                  </div>
                  <div class="form-group">
                    <label for="phone">Contact</label>
                    <input name="phone" type="text" class="form-control" id="phone" placeholder="Telephone">
                  </div>
                  <div class="form-group">
                    <label for="address">Adresse</label>
                    <input name="address" type="text" class="form-control" id="address" placeholder="Adresse complet">
                  </div>
                  <div class="form-group">
                    <label for="idCard">Piece d\'identité</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input name="idCard" type="file" class="custom-file-input" id="idCard">
                        <label  class="custom-file-label" for="idCard">Choisir un document</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Charger</span>
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