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
  <!-- /.content-header -->
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
    @can('superadmin')
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



@endsection
