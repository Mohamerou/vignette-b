
  <!-- Template Main JS & CSSFile -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script>
    jQuery(document).ready(function($) {
        //jQuery Functionality
        $('#example').DataTable();
        $(document).on('click', '#example tbody tr button', function() {
        $("#modaldata tbody tr").html("");
        $("#modaldata tbody tr").html($(this).closest("tr").html());
        $("#exampleModal").modal("show");
        });
    } );
</script>
<style>
    #modaldata tbody tr > td:last-of-type{display:none;}
</style>

@extends ('layouts.admin')

@section('content')

<div class="content-wrapper">

    
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
    
<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
    <h1>Approbation de reception d'engin</h1>
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
<div class="row" style="justify-content: center;">

<div class="col-md-10 " style="justify-item: center;">

<div class="card px-4">
    <div class="card-header">
    <h3 class="card-title">Approbation</h3>
    </div>

    <div class="card-body p-0">
    <table id="example" class="table table-striped table-hover table-bordered">
    <thead>
    <tr>
    <th>Ancien Proprietaire</th>
    <th>Nouveau Proprietaire</th>
    <th style="width: 40px">ACTION</th>
    </tr>
    </thead>
    <tbody>


        @for($i=0; $i < count($Approbations); $i++)
            <tr>
                <td>
                    {{ $Approbations[$i]['oldOwner'] }} 
                    <br> 
                    {{ $Approbations[$i]['oldOwnerPhone'] }}
                </td>
                <td>
                    {{ $Approbations[$i]['newOwner'] }}
                    <br>
                    {{ $Approbations[$i]['newOwnerPhone'] }}
                </td>
                <td>
                <a href="{{ route('newowner', $Approbations[$i]['notificationId']]) }}" class="btn btn-success"><h4>&#x2611; VALIDER</h4></a>
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
