@extends('layouts.app')

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
    
    @can('user')
      <div class="nav-scroller bg-white shadow-sm justify-content-center">
          <nav class="nav nav-underline" aria-label="Secondary navigation">
              <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Tableau de bord</a>
              <a class="nav-link active" aria-current="page" href="#">|</a>
              <a class="nav-link" href="{{ route('engins.index') }}">
                  Mes vignettes
              </a>
              <a class="nav-link active" aria-current="page" href="#">|</a>
              <a class="nav-link" href="{{ route('initiateTransfert') }}">
                  Initier le transfere de propriete d'un engin
              </a>
          </nav>
      </div>
    @endcan

<div class="container mt-5">
    @can('user')
    
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header "></div>

                    <div class="card-body">
                      <div class="text-center">
                        <h4 class="alert-heading">Bienvenue!</h4>
                        <div><a href="{{ route('user.selectEnginType')}}" class="btn btn-outline-primary">Acheter une vignette</a></div>
                        <hr>
                        <p class="mb-0">C'est facile, c'est ikaVignetti.</p>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan
</div>
@endsection
