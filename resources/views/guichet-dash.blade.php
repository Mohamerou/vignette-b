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
          <h1 class="m-0">ACCES RAPIDES</h1>
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

  <!-- /.content-header -->
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->

@can('guichet')
<div class="row justify-content-center">
  <div class="col-6 px-2">
    <!-- small box -->
    <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-info">
      <div class="inner">
        <h4>CAISSE <br> USAGER<h4>
      </div>
      <div class="icon">
        <i class="ionicons ion-ios-cart"></i>
      </div>
      <a href="{{ route('pendingSales') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-6 px-2">
    <!-- small box -->
    <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-secondary">
      <div class="inner">
        <h4>CAISSE <br> GRANDS COMPTES</h4>
      </div>
      <div class="icon">
        <i class="ionicons ion-briefcase"></i>
      </div>
      <a href="{{ route('entPendingSales') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <!-- ./col -->
  <div class="col-6">
    <!-- small box -->
    <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-primary">
      <div class="inner">
        <h4>NOUVEL ENRÔLEMENT USAGER</h4>
      </div>
      <a href="{{ route('enrollStepOne') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-6">
    <!-- small box -->
    <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-info">
      <div class="inner">
        <h4>NOUVEL ENRÔLEMENT GRAND COMPTE</h4>
      </div>
      <a href="{{ route('entEnrollStepOne') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-6">
    <!-- small box -->
    <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-warning">
      <div class="inner">
        <h4>FAIRE UNE IMPRESSION PVC / DUPLICATAT</h4>
      </div>
      <a href="{{ route('csv.list') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
  <div class="col-6">
    <!-- small box -->
    <div class="shadow-lg p-3 mb-5 bg-body rounded small-box bg-success">
      <div class="inner">
        <h4>BASE DE DONNEES USAGERS</h4>
      </div>
      <a href="{{ route('guichet.user.index') }}" class="small-box-footer"><i class="fas fa-arrow-circle-right"></i></a>
    </div>
  </div>
</div>


<hr>



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
            </tr>
            <td>
              <a href="{{ route('mySalesHistory') }}" class="btn btn-block btn-primary btn-lg"><i class="fa fa-book" aria-hidden="true"></i>
              MON HISTORIQUE DE VENTE</a>
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

<hr>



<hr>
<h3>Mes Statistiques de vente du Jour : {{$today}}</h3>
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
        
        <h3>{{ $day_agent_engin_count }}</h3>
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
<h3>Mes Statistiques de vente du mois : {{$current_month}}</h3>
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
          
          <h3>{{ $month_agent_engin_count }}</h3>
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
    <h3>Mes Statistiques de vente de l'année : {{$current_year}}</h3>
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
            
            <h3>{{ $year_agent_engin_count }}</h3>
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
