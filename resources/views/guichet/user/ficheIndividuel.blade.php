<script src="{{ asset('html2pdf/dist/html2pdf.bundle.min.js') }}"></script>

<script>
    function generatePDF() {
        // Choose the element that our invoice is rendered in.
        const element = document.getElementById('info');
        // Choose the element and save the PDF for our user.
        html2pdf().from(element).save();
    }
</script>


@extends ('layouts.admin')

@section('content')
 <!-- Content Wrapper. Contains page content -->
 <div id="info" class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>FICHE INDIVIDUEL USAGER</h1>
          </div>
          <div class="col-sm-6">
            <form>
                <button class="btn btn-info" onclick="generatePDF()">EXPORTER EN PDF</button>
            </form>
          </div>
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admin-dashboard">Accueil</a></li>
              <li class="breadcrumb-item active">Enrollement</li>
            </ol>
          </div> -->
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

      <div id="info" class="container-fluid">

                <!-- Start row -->
                <div class="row">
                <!-- left column -->
                <div class="col-12">
                  <div class="card mb-3 shadow-lg p-3 mb-5 bg-body rounded">
                    <div class="row g-0">
                      <div class="col-6">
                        <img src="{{ asset('storage/'.$data['idCard']) }}" class="img-fluid rounded-start" alt="...">
                      </div>
                      <div class="col-6">
                        <div class="card-body">
                          
                      <!-- general form elements -->
                      <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">INFOS COMPTE</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                       
                            <div class="card-body">
    
                              <div class="col-12">
                                <div class="card">
                                  <!-- /.card-header -->
                                  <div class="card-body table-responsive p-0" style="height: 300px;">
                                    <table class="table table-head-fixed text-nowrap">
                                      <tbody>
                                        <tr>
                                          <th>PRENOM</th>
                                          <td>{{ $data['firstname'] }}</td>
                                        </tr>
                                        <tr>
                                          <th>NOM</th>
                                          <td>{{ $data['lastname'] }}</td>
                                        </tr>
                                        <tr>
                                          <th>CONTACT</th>
                                          <td>{{ $data['phone'] }}</td>
                                        </tr>
                                        <tr>
                                          <th>ADRESSE</th>
                                          <td>{{ $data['address'] }}</td>
                                        </tr>
                                      <tbody>
                                      <!-- On rows -->
                                    </table>
                                  </div>
                                  <!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                              </div>
            
                            </div>
                            <!-- /.card-body -->
    
                        </div>
                        <!-- /.card -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            <!-- /.card --> 
          <!-- </div> -->
          <!--/.col (right) -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection