
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
    <h1>Super Administrateur</h1>
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
    <h3 class="card-title">COMPTES ADMINISTRATEURS</h3>
    </div>

    <div class="card-body p-0">
    <table id="example" class="table table-striped table-hover table-bordered">
    <thead>
    <tr>
    <th>Administrateur</th>
    <th>Acces</th>
    <th style="width: 40px">Modification</th>
    <th style="width: 40px">Suppression</th>
    </tr>
    </thead>
    <tbody>


        @for($i=0; $i < count($user_list); $i++)
            <tr>
                <td>{{ $user_list[$i]['user']->firstname }} {{ $user_list[$i]['user']->lastname }}</td>  
                <td>{{ $user_list[$i]['role'] }}</td>  
                <td class="text-danger">
                <form action="{{ route('superadmin.edit', $user_list[$i]['user']->id) }}" id="edit-form" method="get">
                    @csrf
                <button class="btn btn-warning rounded-3" type="submit">MISE A JOUR</button>
                </form>
                </td>

                <td class="text-danger">
                <form action="{{ route('superadmin.destroy', $user_list[$i]['user']->id) }}" id="delete-form" method="post">
                    @csrf
                    @method('DELETE')
                <button class="btn btn-danger rounded-3" type="submit">SUPPRIMER</button>
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



