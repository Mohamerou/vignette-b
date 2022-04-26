<script src="{{ asset('js/chart/chart.min.js') }}"></script>

@extends('layouts.admin')

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
    
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Tableau de bord</h1>
        </div><!-- /.col -->
        <!-- <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Tableau de bord</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li>
          </ol>
        </div>/.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-md-12">
          <h1 class="m-0">Progression par rapport a la prevision</h1>
        </div><!-- /.col -->
        <div class="col-md-8">
          <p class="text-center">
            <strong></strong>
          </p>



          <div class="progress-group">
            <span class="h5">Total des ventes / Prevision</span>
            <span class="h4 mx-5 text-danger">{{ $poucentage }} %</span><span class="h4 mx-3 float-right"><b>{{ $total_sales }}</b>/{{ $previsionMontant }}</span>
            <div class="progress">
              <div class="progress-bar bg-danger" style="width: {{ $poucentage }}%"></div>
            </div>
          </div>
          <!-- /.progress-group -->
        </div>
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->

    @can('elu')
    <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-info">
            <div class="inner">
              <h3>{{ $total_sales }} FCFA<h3>
              <h4> Ventes journalières </h4>
              <h5>{{$today}}</h5>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-success">
            <div class="inner">
              <h3>{{ $total_sales }} FCFA FCFA</h3>
              <h4>Ventes du mois</h4>
              <h5>{{$current_month}}</h5>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-warning">
            <div class="inner">

              <h3>{{ $vignetted_engin_count }}</h3>
              <h4>Engins enregistrés</h4>
              <h5></h5>

            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-danger">
            <div class="inner">
              <h3>{{ $user_count }}</h3>

              <h4>Usagers enregistrés</h4>
              <h4>&nbsp;</h4>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
    <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-info">
            <div class="inner">
              <h3>{{ $total_sales }} FCFA</h3>
              <h4> Toutes les Ventes </h4>
              <h5>Annee en cours</h5>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->

      <!-- Action Row -->
      <div class="shadow p-3 mb-5 bg-body rounded row">
        <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit"></i>
                Pallette de commande
            </h3>
            </div>
            <div class="card-body pad table-responsive">
            <table class="table table-bordered text-center">
                <tbody><tr>
                <th></th>
                <th></th>
                </tr>
                <tr>
                <td>
                    <button type="button" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
    Rapports Ventes</button>
                </td>
                <td>
                <a href="{{ route('salesHistory') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
              HISTORIQUE VENTE</a>
                </td>
                </tr>
            </tbody></table>
            </div>
            <!-- /.card -->
        </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- End Action Row -->
      <!-- Action Row -->
      <div class="shadow p-3 mb-5 bg-body rounded row">
        <div class="col-md-12">
          <!-- Main row -->
      <div id="printChart">
        <div class="row">
          <!-- Left col -->
          <section class="col-md-12 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card  " >
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-chart-pie mr-1"></i>
                  Ventes
                </h3>
                <div class="card-tools">
                  <ul class="nav nav-pills ml-auto">
                    <li class="nav-item">
                      <a class="nav-link active" href="#revenue-chart" >Area</a>
                    </li>
                  </ul>
                </div>
              </div>
              
              <!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                    <div class="chart tab-pane active" id="revenue-chart"
                      style="position: relative;  ">
                      <!-- <canvas id="myChart"></canvas> -->
                      <canvas id="canvas" height="280" width="600"></canvas>
                    </div>
                  </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </section>

        </div>
      </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- End Action Row -->


      
  
    @endcan

    
    @can('superadmin')
      <!-- Action Row -->
      <div class="shadow p-3 mb-5 bg-body rounded row">
          <div class="col-md-12">
          <div class="card card-primary card-outline">
              <div class="card-header">
              <h3 class="card-title">
                  <i class="fas fa-edit"></i>
                  Pallette de commande
              </h3>
              </div>
              <div class="card-body pad table-responsive">
              <table class="table table-bordered text-center">
                  <tbody><tr>
                  <th></th>
                  <th></th>
                  </tr>
                  <tr>
                  <td>
                      <a class="btn btn-block btn-primary btn-lg" href="{{ route('superadmin.create') }}"><i class="fa fa-book" aria-hidden="true"></i>
                      CREATION DE COMPTE</a>
                  </td>
                  <td>
                  </tr>
                  <tr>
                  <td>
                      <a href="{{ route('superadmin.index') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
                      MODIFICATION / SUPPRESSION DE COMPTE</a>
                  </td>
                  <td>
                  </tr>
              </tbody></table>
              </div>
              <!-- /.card -->
          </div>
          </div>
          <!-- /.col -->
      </div>
      <!-- End Action Row -->
    @endcan

@can('regisseur-public')
<div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-info">
        <div class="inner">
          <h3>{{ $total_sales }} FCFA<h3>
          <h4> Ventes journalières </h4>
          <h5>{{$today}}</h5>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-success">
        <div class="inner">
          <h3>{{ $total_sales }} FCFA</h3>
          <h4>Nombre de vente du msois</h4>
          <h5>{{$current_month}}</h5>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-warning">
        <div class="inner">
          
          <h3>{{ $vignetted_engin_count }}</h3>
          <h4>Engins enregistrés</h4>
          <h5></h5>
          
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-danger">
        <div class="inner">
          <h3>{{ $user_count }}</h3>

          <h4>Usagers enregistrés</h4>
          <h4>&nbsp;</h4>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->

  <!-- Action Row -->
  <div class="shadow p-3 mb-5 bg-body rounded row">
      <div class="col-md-12">
      <div class="card card-primary card-outline">
          <div class="card-header">
          <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Pallette de commande
          </h3>
          </div>
          <div class="card-body pad table-responsive">
          <table class="table table-bordered text-center">
              <tbody><tr>
              <th></th>
              <th></th>
              </tr>
              <tr>
              <td>
                <a class="btn btn-block btn-primary btn-lg" href="{{ route('salesReport') }}"><i class="fa fa-book" aria-hidden="true"></i>Generer un rapports</a>
  </button>
              </td>
              <td>
                <a class="btn btn-block btn-primary btn-lg" href="{{ route('salesHistory') }}"><i class="fa fa-book" aria-hidden="true"></i>Historiques des ventes</a>
              </td>
              </tr>
          </tbody></table>
          </div>
          <!-- /.card -->
      </div>
      </div>
      <!-- /.col -->
  </div>
  <!-- End Action Row -->
@endcan



@can('comptable-public')
<div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-info">
        <div class="inner">
          <h3>{{ $total_sales }} FCFA<h3>
          <h4> Ventes journalières </h4>
          <h5>{{$today}}</h5>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-success">
        <div class="inner">
          <h3>{{ $total_sales }} FCFA</h3>
          <h4>Nombre de vente du msois</h4>
          <h5>{{$current_month}}</h5>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-warning">
        <div class="inner">
          
          <h3>{{ $vignetted_engin_count }}</h3>
          <h4>Engins enregistrés</h4>
          <h5></h5>
          
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-danger">
        <div class="inner">
          <h3>{{ $user_count }}</h3>

          <h4>Usagers enregistrés</h4>
          <h4>&nbsp;</h4>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->

  <!-- Action Row -->
  <div class="shadow p-3 mb-5 bg-body rounded row">
      <div class="col-md-12">
      <div class="card card-primary card-outline">
          <div class="card-header">
          <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Pallette de commande
          </h3>
          </div>
          <div class="card-body pad table-responsive">
          <table class="table table-bordered text-center">
              <tbody><tr>
              <th></th>
              <th></th>
              </tr>
              <tr>
              <td>
                <a href="{{ route('salesHistory') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
                Historiques ventes</a>
              </td>
              <td>
                  <a href="{{ route('enroll.index') }}" class="btn btn-block btn-primary btn-lg"> <i class="fa fa-archive" aria-hidden="true"></i>
  Historiques enrollements</a>
              </td>
              </tr>
              <tr>
              <td>
                  <a href="{{ route('agent.create') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
  Ajouter un agent</a>
              </td>
              <td>
                  <a href="{{ route('agent.index') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
  Liste des agents</a>
              </td>
              </tr>
              <tr>
                <td>
                  <a href="{{ route('prevision.index') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
                  Definir une prevision</a>
                </td>
               
                </tr>
          </tbody></table>
          </div>
          <!-- /.card -->
      </div>
      </div>
      <!-- /.col -->
  </div>
  <!-- End Action Row -->
@endcan

@can('guichet')
<div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-info">
        <div class="inner">
          <h3>{{ $total_sales }} FCFA<h3>
          <h4> Ventes journalières </h4>
          <h5>{{$today}}</h5>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-success">
        <div class="inner">
          <h3>{{ $total_sales }} FCFA</h3>
          <h4>Nombre de vente du msois</h4>
          <h5>{{$current_month}}</h5>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-warning">
        <div class="inner">
          
          <h3>{{ $vignetted_engin_count }}</h3>
          <h4>Engins enregistrés</h4>
          <h5></h5>
          
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-danger">
        <div class="inner">
          <h3>{{ $user_count }}</h3>

          <h4>Usagers enregistrés</h4>
          <h4>&nbsp;</h4>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->

  <!-- Action Row -->
  <div class="shadow p-3 mb-5 bg-body rounded row">
      <div class="col-md-12">
      <div class="card card-primary card-outline">
          <div class="card-header">
          <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Pallette de commande
          </h3>
          </div>
          <div class="card-body pad table-responsive">
          <table class="table table-bordered text-center">
              <tbody><tr>
              <th></th>
              <th></th>
              </tr>
              <tr>
              <td>
                  <a href="{{ route('enrollStepOne') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
  Nouvel Enrollement</a>
              </td>
              <td>
                  <a href="{{ route('enrollList') }}" class="btn btn-block btn-primary btn-lg"> <i class="fa fa-archive" aria-hidden="true"></i>
  Enrollements Recents</a>
              </td>
              </tr>
              <tr>
              <td>
                  <a href="{{ route('guichet.user.index') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
  Liste des usagers</a>
              </td>
              </tr>
              <td>
                  <a href="{{ route('enroll.index') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
  Historique Enrollement</button>
              </td>
              </tr>
          </tbody></table>
          </div>
          <!-- /.card -->
      </div>
      </div>
      <!-- /.col -->
  </div>
  <!-- End Action Row -->


  <!-- Action Row -->
  <div class="shadow p-3 mb-5 bg-body rounded row">
      <div class="col-md-12">
      <div class="card card-primary card-outline">
          <div class="card-header">
          <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Pallette de commande
          </h3>
          </div>
          <div class="card-body pad table-responsive">
          <table class="table table-bordered text-center">
              <tbody><tr>
              <th></th>
              <th></th>
              </tr>
              <tr>
              <td>
                  <a href="{{ route('pendingSales') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
  PANEL DE VENTE</a>
              </td>
              </tr>

              <tr>
              <td>
                  <a href="{{ route('csv.list') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
  IMPRESSION PVC</a>
              </td>
              </tr>
              <td>
                <a href="{{ route('salesHistory') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
                HISTORIQUE VENTE</a>
              </td>
              </tr>
          </tbody></table>
          </div>
          <!-- /.card -->
      </div>
      </div>
      <!-- /.col -->
  </div>
  <!-- End Action Row -->
@endcan

     




<script>
function imprimer(printChart) {
   var printContents = document.getElementById(printChart).innerHTML;
   var originalContents = document.body.innerHTML;
   document.body.innerHTML = printContents;
   window.print();
   document.body.innerHTML = originalContents;
   }
</script>





<!-- //////////////////////////////////////////////////////// -->

<script>
  var _xdata = {!! $monthCountEngins !!};
  var _ydata = {!! json_encode($months) !!};
</script>

<script>
const ctx = document.getElementById('canvas').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: _ydata,
        datasets: [{
            label: '# Engins',
            data: _xdata,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>


<!-- <script>
    var chartdata = {
    type: 'bar',
    data: {
    labels: 
    // labels: month,
    datasets: [
    {
    label: 'this year',
    backgroundColor: '#26B99A',
    borderWidth: 1,
    data: 
    }
    ]
    },
    options: {
    scales: {
    yAxes: [{
    ticks: {
    beginAtZero:true
    }
    }]
    }
    }
    }
    var ctx = document.getElementById('canvas').getContext('2d');
    new Chart(ctx, chartdata);
  </script> -->
<!-- /.content-wrapper -->
@endsection
