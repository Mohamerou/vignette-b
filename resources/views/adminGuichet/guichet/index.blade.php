@extends ('layouts.admin')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1>Tous les guichets</h1>
</div>
<div class="col-sm-6">
<ol class="breadcrumb float-sm-right">
<li class="breadcrumb-item"><a href="admin-dashboard"></a></li>
</ol>
</div>
</div>
</div>
</section>

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

            <div class="col-md-6">

                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Guichets d'Enrollement</h3>
                    </div>

                    <div class="card-body p-0">
                    <table class="table table-striped">
                    <thead>
                    <tr>
                    <th>Type Guichet</th>
                    <th>Numero</th>
                    <th>Historique</th>
                    @can('reporteur')
                    <th>Rapport</th>
                    @endcan
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($guichet_enrolls as $guichet_enroll)
                        <tr>
                            <td>{{ $guichet_enroll->type }}</td>
                            <td>{{ $guichet_enroll->number }}</td>

                            <td>
                                <button type="button" class="btn btn-outline-primary btn-icon-text">
                                    <i class="ti-file btn-icon-prepend"></i>
                                    Historique
                                </button>
                            </td>

                            @can('reporteur')
                            <td>
                                <button type="button" class="btn btn-outline-primary btn-icon-text">
                                    <i class="ti-file btn-icon-prepend"></i>
                                    Rapport
                                </button>
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                    </div>

                    </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">Guichets de Vente</h3>
                    </div>

                    <div class="card-body p-0">
                    <table class="table table-striped">
                    <thead>
                    <tr>
                    <th>Type Guichet</th>
                    <th>Numero</th>
                    <th>Historique</th>
                    @can('reporteur')
                    <th>Rapport</th>
                    @endcan
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($guichet_ventes as $guichet_vente)
                        <tr>
                            <td>{{ $guichet_vente->type }}</td>
                            <td>{{ $guichet_vente->number }}</td>

                            <td>
                                <button type="button" class="btn btn-outline-primary btn-icon-text">
                                    <i class="ti-file btn-icon-prepend"></i>
                                    Historique
                                </button>
                            </td>

                            @can('reporteur')
                            <td>
                                <button type="button" class="btn btn-outline-primary btn-icon-text">
                                    <i class="ti-file btn-icon-prepend"></i>
                                    Rapport
                                </button>
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                    </tbody>
                    </table>
                    </div>

                    </div>

                    </div>

                </div>

            </div>
        </div>

    </div>
</section>

</div>
@endsection