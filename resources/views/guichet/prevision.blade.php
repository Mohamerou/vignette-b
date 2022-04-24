
  <!-- Template Main JS & CSSFile -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script>
    jQuery(document).ready(function($) {
        //jQuery Functionality
        $('#example').DataTable();
        $(document).on('click', '#example tbody tr button', function() {       
        $("#modaldata tbody tr").html("");
        $("#modaldata tbody tr").html($(this).closest("tr").html());
        $("#exampleModal").modal("show");
        });
    } );
</script>
<style>
    #modaldata tbody tr > td:last-of-type{display:none;}
</style>




@extends ('layouts.admin')

@section('content')


@if (isset($previsionEdit))
    @if (empty($previsionList) && empty( $prevision) && empty($lastPrevision))

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Modification de la prevision</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="admin-dashboard">Accueil</a></li>
              <li class="breadcrumb-item active">Prevision</li>
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
                <h3 class="card-title">Donnees de prevision</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" action="{{ route('prevision.update', $previsionEdit->id) }}">
                @csrf
                @method('PUT')

                <div class="card-body">
                  <div class="form-group">
                    <label for="montant">Montant</label>
                    <input value="{{ $previsionEdit->montant }}" name="montant" type="number" class="form-control" id="montant">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">MODIFIER</button>
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
@endif
@endif

@if(isset($lastPrevision) && isset($previsions))
    @if(!empty($lastPrevision) && !empty($previsions))
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Definir une prevision</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="admin-dashboard">Accueil</a></li>
                    <li class="breadcrumb-item active">Prevision</li>
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
                        <h3 class="card-title">Donnees de prevision</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('prevision.store') }}">
                        @csrf

                        <div class="card-body">
                        <div class="form-group">
                            <label for="montant">Montant</label>
                            <input name="montant" type="number" class="form-control" id="montant">
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
            <div class="card px-4">
                <div class="card-header">
                <h3 class="card-title"> Historique des Previsions</h3>
                </div>
            
                <div class="card-body p-0">
                <table id="example" class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th>PREVISION</th>
                    <th>DATE</th>
                <th style="width: 40px">Actions</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$lastPrevision->montant }} </td>
                        <td>{{$lastPrevision->updated_at }} </td>
                        <td>
                            <a href="{{ route('prevision.edit', $lastPrevision->id) }}"   class="btn btn-warning"><h4>&#9998;</h4></a>
                        </td>

                    </tr>
            
                @foreach ($previsions as $prevision )
            
                    <tr>
                            <td>{{ $prevision->montant}}</td>
                            <td>{{ $prevision->updated_at}}</td>
                            <td>
                            <button disabled type="button" class="btn btn-success"><h4>&#x2611;</h4></button>
                            </td>
                        </tr>
                    @endforeach
            
            
                </tbody>
                </table>
                </div>
            
                </div>
            
                </div>
            
            </div>
            
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @endif
    @endif



@endsection