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
          <h1 class="m-0">Accès rapides</h1>
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

  @can('prevision')
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
  <!-- Content Header (Page header) -->

  <!-- /.content-header -->
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->

@can('comptable-public')
<!-- Action Row -->
  <div class="shadow p-3 mb-5 bg-body rounded row">
      <div class="col-md-12">
      <div class="card card-primary card-outline">
          <div class="card-header">
          <h3 class="card-title">
              <i class="fas fa-edit"></i>
              Palette de commande
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
  
<h3>Statistiques du Jour : {{$today}}</h3>
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
<h3>Statistiques du mois : {{$current_month}}</h3>
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
    <h3>Statistique de l'année : {{$current_year}}</h3>
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
@endcan
@endsection
