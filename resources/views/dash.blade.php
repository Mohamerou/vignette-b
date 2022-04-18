@extends('layouts.admin')

@section('content')

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

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->

    @can('elu')
    <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>115</h3>
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
          <div class="small-box bg-success">
            <div class="inner">
              <h3>1369</h3>
              <h4>Nombre de vente du mois</h4>
              <h5>{{$month}}</h5>
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
          <div class="small-box bg-warning">
            <div class="inner">

              <h3>1369</h3>
              <h4>Engins enroller</h4>
              <h5>{{$month}}</h5>

            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>1965</h3>

              <h4>Utilisateurs Enroller</h4>
              <h4>&nbsp;</h4>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
    <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>35000</h3>
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
      <div class="row">
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
                      <button type="button" class="btn btn-block btn-primary btn-lg"> <i class="fa fa-archive" aria-hidden="true"></i>
      Historiques</button>
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

@can('reporteur')
<div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>115</h3>
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
      <div class="small-box bg-success">
        <div class="inner">
          <h3>1369</h3>
          <h4>Nombre de vente du mois</h4>
          <h5>{{$month}}</h5>
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
      <div class="small-box bg-warning">
        <div class="inner">
          
          <h3>1369</h3>
          <h4>Engins enroller</h4>
          <h5>{{$month}}</h5>
          
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>1965</h3>

          <h4>Utilisateurs Enroller</h4>
          <h4>&nbsp;</h4>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->

  <!-- Action Row -->
  <div class="row">
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
  Generer un rapports</button>
              </td>
              <td>
                  <button type="button" class="btn btn-block btn-primary btn-lg"> <i class="fa fa-archive" aria-hidden="true"></i>
  Historiques des ventes</button>
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

@can('superviseur')
<div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>115</h3>
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
      <div class="small-box bg-success">
        <div class="inner">
          <h3>1369</h3>
          <h4>Nombre de vente du mois</h4>
          <h5>{{$month}}</h5>
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
      <div class="small-box bg-warning">
        <div class="inner">
          
          <h3>1369</h3>
          <h4>Engins enroller</h4>
          <h5>{{$month}}</h5>
          
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>1965</h3>

          <h4>Utilisateurs Enroller</h4>
          <h4>&nbsp;</h4>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->

  <!-- Action Row -->
  <div class="row">
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
  Historiques ventes</button>
              </td>
              <td>
                  <a href="{{ route('enroll.index') }}" class="btn btn-block btn-primary btn-lg"> <i class="fa fa-archive" aria-hidden="true"></i>
  Historiques enrollements</a>
              </td>
              </tr>
              <tr>
              <td>
                  <a href="{{ route('guichet.create') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
  Ajouter un guichet</a>
              </td>
              <td>
                  <a href="{{ route('guichet.index') }}" class="btn btn-block btn-primary btn-lg"> <i class="fa fa-archive" aria-hidden="true"></i>
  Liste des guichets</a>
              </td>
              </tr>
              <tr>
              <td>
                  <a href="{{ route('agent.create') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
  Ajouter un agent</a>
              </td>
              <td>
                  <a href="#" class="btn btn-block btn-primary btn-lg"> <i class="fa fa-archive" aria-hidden="true"></i>
  Liste des Agents</button>
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

@can('agent_enroll')
<div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>115</h3>
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
      <div class="small-box bg-success">
        <div class="inner">
          <h3>1369</h3>
          <h4>Nombre de vente du mois</h4>
          <h5>{{$month}}</h5>
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
      <div class="small-box bg-warning">
        <div class="inner">
          
          <h3>1369</h3>
          <h4>Engins enroller</h4>
          <h5>{{$month}}</h5>
          
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>1965</h3>

          <h4>Utilisateurs Enroller</h4>
          <h4>&nbsp;</h4>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->

  <!-- Action Row -->
  <div class="row">
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
              <td>
                  <a href="{{ route('enroll.index') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
  Historique</button>
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

@can('agent_vente')
<div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>115</h3>
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
      <div class="small-box bg-success">
        <div class="inner">
          <h3>1369</h3>
          <h4>Nombre de vente du mois</h4>
          <h5>{{$month}}</h5>
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
      <div class="small-box bg-warning">
        <div class="inner">
          
          <h3>1369</h3>
          <h4>Engins enroller</h4>
          <h5>{{$month}}</h5>
          
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3>1965</h3>

          <h4>Utilisateurs Enroller</h4>
          <h4>&nbsp;</h4>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <a href="#" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->

  <!-- Action Row -->
  <div class="row">
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
  Panel de vente</button>
              </td>
              </tr>
              <td>
                  <button type="button" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
  Historique</button>
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

@can('elu')
      <!-- Main row -->
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
                    <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                  </li>
                </ul>
              </div>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content p-0">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="revenue-chart"
                     style="position: relative;  ">
                     <canvas id="myChart"></canvas></div>
                </div>
                <div class="chart tab-pane" id="sales-chart" style="position: relative; ">
                  <canvas id="sales-chart-canvas"   ></canvas>
                </div>
              </div>
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->




        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

          <!-- Map card -->
          <div class="card bg-gradient-primary">
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-map-marker-alt mr-1"></i>
                Utilisateurs
              </h3>
              <!-- card tools -->
              <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                  <i class="far fa-calendar-alt"></i>
                </button>
                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            <div class="card-body">
              <div id="world-map" style="height: 250px; width: 100%;"></div>
            </div>
            <!-- /.card-body-->
            <div class="card-footer bg-transparent">
              <div class="row">
                <div class="col-4 text-center">
                  <div id="sparkline-1"></div>
                  <div class="text-white">Visitors</div>
                </div>
                <!-- ./col -->
                <div class="col-4 text-center">
                  <div id="sparkline-2"></div>
                  <div class="text-white">Online</div>
                </div>
                <!-- ./col -->
                <div class="col-4 text-center">
                  <div id="sparkline-3"></div>
                  <div class="text-white">Sales</div>
                </div>
                <!-- ./col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.card -->
          <div class="col-md-10 offset-md-1">
            <div class="panel panel-default">
                <div class="panel-heading">Tableau de bord</div>
                <div class="panel-body">
                    <canvas id="canvas" height="280" width="600"></canvas>
                </div>
            </div>

            <div>



        </section>
        <!-- right col -->
      </div>
@endcan
      <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels = [
    'Janvier',
    'Février',
    'Mars',
    'Avril',
    'Mai',
    'ecembre',
    'Juillet',
    'Août',
    'Septembre',
    'Octobre',
    'Novembre',
    'Decembre',
  ];

  const data = {
    labels: labels,
    datasets: [{
      label: 'Statistique des ventes',
      backgroundColor: 'rgb(255, 99, 132)',
      borderColor: 'rgb(255, 99, 132)',
      data: [0, 10, 5, 2, 20, 30, 45,60,30,20,80,70,40],
    }]
  };

  const config = {
    type: 'line',
    data: data,
    options: {}
  };
</script>
<script>
  const myChart = new Chart(
    document.getElementById('myChart'),
    config
  );
</script>
<!-- /.content-wrapper -->
@endsection
