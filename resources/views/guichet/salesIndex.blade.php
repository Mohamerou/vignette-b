@extends ('layouts.admin')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
<h1>FILS D'ATTENTE</h1>
<h1>Usagers : {{ count($pendingSales) }} en attente.</h1>
</div>
<div class="col-sm-6">
<ol class="breadcrumb float-sm-right">
<!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
<li class="breadcrumb-item active">Simple Tables</li>
</ol> -->
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
    <h3 class="card-title">Enrollement recent</h3>
    </div>

    <div class="card-body p-0">
    <table class="table table-striped">
    <thead>
    <tr>
    <th>Guichet</th>
    <th>Usager</th>
    <th>Contact Usager</th>
    <th>Chassie Engin</th>
    <th style="width: 40px">Status</th>
    <th style="width: 40px">Action</th>
    </tr>
    </thead>
    <tbody>

        @for ($i=0; $i < count($pendingSales); $i++)
        <tr>
            <td>{{ $pendingSales[$i]['guichet'] }}</td>
            <td>{{ $pendingSales[$i]['usager'] }}</td>
            <td>{{ $pendingSales[$i]['userphone'] }}</td>
            <td>{{ $pendingSales[$i]['chassie'] }}</td>
            <td class="text-danger">Attente</td>
            <td>
                <form action="{{ route('salesStepOne') }}" method="post">
                    @csrf
                    <input required name="enrollId" type="hidden" value={{ $pendingSales[$i]['enrollId'] }}>
                    <button type="submit" class="btn btn-primary">CAISSE </button>
                </form>
            </td>

        </tr>
        @endfor
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