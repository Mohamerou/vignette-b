


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
@can('prevision')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-md-12">
        <h1 class="m-0">Progression par rapport à la prévision</h1>
      </div><!-- /.col -->
      <div class="col-md-8">
        <p class="text-center">
          <strong></strong>
        </p>



        <div class="progress-group">
          <span class="h5">Total des ventes / Prévision</span>
          <span class="h4 mx-5 text-danger">{{ $pourcentage }} %</span><span class="h4 mx-3 float-right"><b>{{ $total_sales }}</b>/{{ $previsionMontant }}</span>
          <div class="progress">
            <div class="progress-bar bg-danger" style="width: {{ $pourcentage }}%"></div>
          </div>
        </div>
        <!-- /.progress-group -->
      </div>
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
@endcan
  <!-- /.content-header -->
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->

    @can('elu')

          <!-- Action Row -->
          <div class="shadow p-3 mb-5 bg-body rounded row">
            <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i>
                    ACTIONS RAPIDES
                </h3>
                </div>
                <div class="card-body pad table-responsive">
                <table class="table table-bordered text-center">
                    <tbody><tr>
                    <th></th>
                    </tr>
                    <tr>
                    <td>
                      <a href="{{ route('sales.report.index') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
                    RAPPORTS JOURNALIERS</a>
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


        <h3>Les Statistiques de vente du Jour : {{$today}}</h3>
        <div class="row justify-content-center">
          <div class="col-6">
            <!-- small box -->
            <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-info">
              <div class="inner">
                <p>{{ $day_sales }} FCFA<h3>
                <h4> Ventes </h4>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        
        
          <!-- ./col -->
          <div class="col-6">
            <!-- small box -->
            <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-warning">
              <div class="inner">
                
                <h3>{{ $day_engin_count }}</h3>
                <h4>Engins </h4>
                <h5></h5>
                
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          
        </div>
        <hr>
        <h3>Les Statistiques de vente du mois : {{$current_month}}</h3>
          <!-- /.row -->
          <div class="row">
            <div class="col-6">
              <!-- small box -->
              <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-info">
                <div class="inner">
                  <p>{{ $month_sales }} FCFA<h3>
                  <h4> Ventes </h4>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
        
            <!-- ./col -->
            <div class="col-6">
              <!-- small box -->
              <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-warning">
                <div class="inner">
                  
                  <h3>{{ $month_engin_count }}</h3>
                  <h4>Engins </h4>
                  <h5></h5>
                  
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
        <hr>
            <h3>Les Statistiques de vente de l'année : {{$current_year}}</h3>
            <div class="row">
              <div class="col-6">
                <!-- small box -->
                <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-info">
                  <div class="inner">
                    <p>{{ $year_sales }} FCFA<p>
                    <h4> Ventes </h4>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
        
              <!-- ./col -->
              <div class="col-6">
                <!-- small box -->
                <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-warning">
                  <div class="inner">
                    
                    <h3>{{ $year_engin_count }}</h3>
                    <h4>Engins </h4>
                    <h5></h5>
                    
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
                        Interpretations graphique des resultats
                        </h3>
                        <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                            <a class="nav-link active" href="#revenue-chart-bar" >REVENUE / MOIS</a>
                            </li>
                        </ul>
                        </div>
                    </div>
                    
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content p-0">
                        <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="revenue-chart-bar"
                            style="position: relative;  ">
                            <!-- <canvas id=bar"></canvas> -->
                            <canvas id="bar" height="280" width="600"></canvas>
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
    </div>
        <!-- /.col -->
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
                            <a class="nav-link active" href="#revenue-chart-doughnut" >REVENUE / MOIS</a>
                            </li>
                        </ul>
                        </div>
                    </div>
                    
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content p-0">
                        <!-- Morris chart - Sales -->
                            <div class="chart tab-pane active" id="revenue-chart-doughnut"
                            style="position: relative;  ">
                            <!-- <canvas id=bar"></canvas> -->
                            <canvas id="doughnut" height="280" width="600"></canvas>
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
    </div>
        <!-- /.col -->
    <!-- End Action Row -->
@endcan



<!-- //////////////////////////////////////////////////////// -->

<script>
  var _xdata = {!! $monthCountBenefit !!};
  var _ydata = {!! json_encode($months) !!};
</script>

<script>
const ctx = document.getElementById('bar').getContext('2d');
const barChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: _ydata,
        datasets: [
          {
            label: ' Revenue par mois',
            data: _xdata,
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(25, 255, 66, 0.6)',
                'rgba(132, 99, 255, 0.6)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(25, 255, 66, 1)',
                'rgba(132, 99, 255, 1)',
            ],

            borderRadius: 15,

            borderWidth: 1
          }
      ]
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

<script>
const ctx_doughnut = document.getElementById('doughnut').getContext('2d');
const doughnut = new Chart(ctx_doughnut, {
    type: 'doughnut',
    data: {
        labels: _ydata,
        datasets: [
          {
            label: ' Revenue par mois',
            data: _xdata,
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(25, 255, 66, 0.6)',
                'rgba(132, 99, 255, 0.6)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(25, 255, 66, 1)',
                'rgba(132, 99, 255, 1)',
            ],

            borderRadius: 15,

            borderWidth: 1
          }
      ]
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
@endsection
