@extends ('layouts.admin')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1>Historiques des enrollements</h1>
</div>
<div class="col-sm-6">
<ol class="breadcrumb float-sm-right">
<li class="breadcrumb-item"><a href="admin-dashboard">Historiques</a></li>
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
    <h3 class="card-title">Tous les enrollements</h3>
    </div>

    <div class="card-body p-0">
    <table class="table table-striped">
    <thead>
    <tr>
    <th>#</th>
    <th>Guichet</th>
    <th>Agent</th>
    <th>Agent Contact</th>
    <th>Context</th>
    <th>Status</th>
    </tr>
    </thead>
    <tbody>
        @foreach($enrollHistories as $enrollHistory)
        <tr>
            <td>{{$enrollHistory->id}}</td>
            <td>{{$enrollHistory->guichetRef}}</td>
            <td>{{$enrollHistory->agentName}}</td>
            <td>{{$enrollHistory->agentPhone}}</td>
            <td class="text-danger">Enrollement</td>
            @if($enrollHistory->status == 0)
                <td class="text-danger">Attente</td>
            @else
                <td class="text-success">Traité</td>
            @endif
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