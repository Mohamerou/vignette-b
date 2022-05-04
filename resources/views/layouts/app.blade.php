<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ikaVignetti') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app" class="">
        <nav class="navbar navbar-expand-md navbar-light fixed-top bg-white shadow-sm" style="margin: auto;">
            <div class="container" style="">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img style="width:50px; height:50px;" src="{{ asset('/images/logo.png') }}"
                        class="navbar-brand-img" alt="Logo ikaVignetti">
                </a>
                {{-- <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'ikaVignetti') }}
                </a> --}}
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('connexion') }}">{{ __('Connexion') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('inscription') }}">{{ __('Creer un compte') }}</a>
                                </li>
                            @endif
                        @else
                            @can('user')
                                <li class="nav-item dropdown">
                                    @if (auth()->user()->unReadNotifications->count() != 0)
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle btn btn-light" href="#"
                                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            v-pre>
                                            Notifications
                                            <span class="badge bg-primary text-light">
                                                <b> {{ auth()->user()->unReadNotifications->count() }} </b>
                                            </span>
                                        </a>
                                    @else
                                    @endif

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @foreach (auth()->user()->unreadNotifications as $notification)
                                            <a class="dropdown-item bg-light"
                                                href="{{ route('engin.notification.type', $notification->id) }}">
                                                {{ $notification->data['subject'] }} | <small>
                                                    {{ $notification->created_at }}</small>
                                            </a>
                                        @endforeach


                                    </div>

                                </li>
                            @endcan

                            @can('agent_vente')
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle btn btn-light" href="#" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Notifications <span class="badge bg-primary text-light">
                                            @if (auth()->user()->unReadNotifications->count() != 0)
                                                <b> {{ auth()->user()->unReadNotifications->count() }} </b>
                                            @else
                                            @endif
                                        </span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @foreach (auth()->user()->notifications as $notification)
                                            @if (empty($notification->read_at))
                                                <a class="dropdown-item bg-light"
                                                    href="{{ route('examinerDemande', ['usagerId' => $notification->data['userId'],'enginId' => $notification->data['enginId'],'notificationId' => $notification->id,'demandeTrackId' => $notification->data['demandeTrackId']]) }}">
                                                    {{ $notification->data['subject'] }} | <small>
                                                        {{ $notification->created_at }}</small>
                                                </a>
                                            @else
                                                <a class="dropdown-item bg-white"
                                                    href="{{ route('examinerDemande', ['usagerId' => $notification->data['userId'],'enginId' => $notification->data['enginId'],'notificationId' => $notification->id,'demandeTrackId' => $notification->data['demandeTrackId']]) }}">
                                                    {{ $notification->data['subject'] }} | <small>
                                                        {{ $notification->created_at }}</small>
                                                </a>
                                            @endif
                                        @endforeach


                                    </div>

                                </li>
                            @endcan

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->firstname }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('deconnexion') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Deconnexion') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('deconnexion') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @can('user')
            <div class="nav-scroller bg-white shadow-sm">
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
        <main class="py-4">
            @yield('content')
        </main>

        <footer class="mastfoot mt-auto text-center py-10">
            <div class="inner">
                Copyrights &copy 2021 ikaVignetti | Tous droits réservés
            </div>
        </footer>
    </div>
</body>

</html>
