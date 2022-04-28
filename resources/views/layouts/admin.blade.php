<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ikaVignetti</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset('admindash/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('admindash/dist/css/adminlte.min.css') }}">
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}" />
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('get_admin_dash') }}" class="nav-link">Accuiel</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li> -->

      <!-- Messages Dropdown Menu -->
      @if(auth()->user()->unReadNotifications->count() != 0)

      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">
                <h4> {{ auth()->user()->unReadNotifications->count() }} </h4>
          </span>
        </a> 
        @foreach(auth()->user()->notifications as $notification)
            @if(empty($notification->read_at))
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                  <a href="{{ route('approve.index') }}" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                      <img src="{{ asset('images/avatar.png') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                      <div class="media-body">
                        <b class="dropdown-item-title">
                          {{ $notification->data['subject']  }}
                          <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                        </b>
                        <p class="text-sm"></p>
                        <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> {{ $notification->created_at }}</p>
                      </div>
                    </div>
                    <!-- Message End -->
                 </a>
                  <div class="dropdown-divider"></div>
                </div> 
            @endif
        @endforeach
      </li> 
      @else
      @endif
      <!-- Notifications Dropdown Menu -->
      <!-- <li class="nav-item dropdown"> -->
        <!-- <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a> -->
        <!-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div> -->
      <!-- </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('get_admin_dash') }}" class="brand-link">
      <img src="{{ asset('images/logo.png') }}" alt="ikaVignetti LOGO" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">ikaVignetti</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('images/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ route('get_admin_dash') }}" class="d-block">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Panneau de contrôle
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            @can('elu')
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('sales.report.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Rapport des Ventes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('salesHistory') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Historiques des Ventes</p>
                    </a>
                </li>
                </ul>
            @endcan
            @can('guichet')
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="/enrollement-1" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Nouvel Enrollement</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('enrollList') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Enrollements Récents</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('enroll.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Historiques Enrollements</p>
                    </a>
                </li>
                </ul>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('pendingSales') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Nouvel Vente</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('salesHistory') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Historiques Ventes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('guichet.user.index') }}" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Liste des usagers</p>
                    </a>
                </li>
                </ul>
          </li>
          @endcan
          @can('regisseur-public')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Rapports
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('salesReport') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Generer le rapport journalier</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('sales.report.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lister les rapports</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('salesHistory') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Historique des ventes</p>
                </a>
              </li>
            </ul>
          </li>
          @endcan
          @can('superadmin')
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                GESTION DE COMPTE
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('superadmin.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>CREATION DE COMPTE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('superadmin.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>MODIFICATION / SUPPRESSION DE COMPTE</p>
                </a>
              </li>
            </ul>
          </li>
          @endcan
          
          @can('comptable-public')

          <li class="nav-item">
            <!-- <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Gestion des Guichets
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a> -->
            <ul class="nav nav-treeview">
              <!-- <li class="nav-item">
                <a href="{{ route('guichet.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nouveau Guichet</p>
                </a>
              </li> -->
              <!-- <li class="nav-item">
                <a href="{{ route('guichet.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Liste des guichets</p>
                </a>
              </li> -->
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Gestion des Agents
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('agent.create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Nouveau Agent</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('agent.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Liste des Agents</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Historiques
                <i class="fas fa-angle-left right"></i>
                
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('salesHistory') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Historique des Ventes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('enroll.index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Historique des Enrollements</p>
                </a>
              </li>
            </ul>
          </li>
          @endcan
          <li class="nav-header">Authentification</li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('deconnexion') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                     <i class="nav-icon far fa-circle text-danger"></i>
                                        {{ __('Deconnexion') }}
                                    </a>
            <form id="logout-form" action="{{ route('deconnexion') }}" method="POST" class="d-none">
                @csrf
            </form>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  @yield('content')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>&copy; 2022-2023 <a href="/">ikaVignetti</a>.</strong>
    Tout Droits réservés.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('admindash/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('admindash/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('admindash/dist/js/adminlte.js') }}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('admindash/plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('admindash/dist/js/pages/dashboard3.js') }}"></script>
</body>
</html>
