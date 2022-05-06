
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

<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
    <h1>Enrollements Recent</h1>
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
    <h3 class="card-title">Enrollement Recent</h3>
    </div>

    <div class="card-body p-0">
    <table id="example" class="table table-striped table-hover table-bordered">
    <thead>
    <tr>
    <th>Guichet</th>
    <th>Usager</th>
    <th>Contact Usager</th>
    <th>Date</th>
    <th>Status</th>
    @can('guichet')
        <th style="width: 40px">Actions</th>
    @endcan
    </tr>
    </thead>
    <tbody>


        @for($i=0; $i < count($pendingEnrolls); $i++)
            <tr>
                <td>{{ $pendingEnrolls[$i]['guichet'] }}</td>
                <td>{{ $pendingEnrolls[$i]['usager'] }}</td>
                <td>{{ $pendingEnrolls[$i]['userphone'] }}</td>
                <td>{{ $pendingEnrolls[$i]['date'] }}</td>
                <td class="text-danger">Attente</td>

                @can('guichet')    
                    <td class="text-danger">
                        <a href="{{ route('enrollStepTwo', $pendingEnrolls[$i]['userId']) }}" class="btn btn-warning"><h3>&#8594;</h3></a>
                    </td>
                @endcan
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



