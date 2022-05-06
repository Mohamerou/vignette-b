@extends ('layouts.admin')

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Enrollement Entreprise</h1>
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
                <h3 class="card-title">Infos Entreprise</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('entPostStepOne') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="lastname">Nom de l'entreprise</label>
                    <input required name="lastname" type="text" class="form-control" id="lastname" placeholder="Nom">
                  </div>
                  <div class="form-group">
                    <label for="firstname">Status de l'entreprise</label>
                    <input required name="firstname" type="text" class="form-control" id="firstname" placeholder="status">
                  </div>
                  <div class="form-group">
                    <label for="phone">Contact</label>
                    <input required name="phone" type="text" class="form-control" id="phone" placeholder="Telephone">
                  </div>

                  {{-- <div class="form-group">
                    <label for="account_type" class="form-label font-weight-bold">Type de compte</label>
                    <select name="account_type" id="account_type" class="form-control" required id="account_type">
                        <option value="">Selectionner</option>
                            <option value="usager">Usager</option>
                            <option value="entreprise">Entreprise</option>
                    </select>
                  </div> --}}
                  <input required name="account_type" value="entreprise" type="hidden" class="form-control" id="address" placeholder="Adresse complet">


                  <div class="form-group">
                    <label for="address">Adresse</label>
                    <input required name="address" type="text" class="form-control" id="address" placeholder="Adresse complet">
                  </div>
                  <div class="form-group">
                    <label for="idCard">Document d'identification de l'entreprise</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input required name="idCard" type="file" class="custom-file-input" id="idCard">
                        <label  class="custom-file-label" for="idCard">Choisir un document</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text"></span>
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