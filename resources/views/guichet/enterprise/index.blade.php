
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
<script src="{{ asset('html2pdf/dist/html2pdf.bundle.min.js') }}"></script>

<script>
    function generatePDF() {
        // Choose the element that our invoice is rendered in.
        const element = document.getElementById('printPdf');
        // Choose the element and save the PDF for our user.
        html2pdf().from(element).save();
    }
</script>
<style>
    #modaldata tbody tr > td:last-of-type{display:none;}
</style>

@extends ('layouts.admin')

@section('content')

<div class="content-wrapper">
<div id="printPdf" >
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
    <div class="col-sm-6">
        <h1>Liste des Entreprises</h1>
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
    <h3 class="card-title"></h3>
    </div>

    <div class="card-body p-0">
    <table id="example" class="table table-striped table-hover table-bordered">
    <thead>
    <tr>
    <th>Entreprise</th>
    <th>CONTACT Entreprise</th>
    <th>ADRESSE</th>
    <th>DATE</th>
    <th>DETAILS</th>
    <th style="width: 40px">ACTIONS</th>
    </tr>
    </thead>
    <tbody>

        @for($i=0; $i < count($user_list); $i++)
            <tr>
<<<<<<< HEAD:resources/views/guichet/salesHistoryFilter.blade.php
                <td>{{ $SalesHistories[$i]['agent'] }}</td>
                <td>{{ $SalesHistories[$i]['usager'] }}</td>
                <td>{{ $SalesHistories[$i]['userphone'] }}</td>
                <td style="width: 160px !important;">
                    {{ $SalesHistories[$i]['marque'] }}
                </td>
                <td>{{ $SalesHistories[$i]['modele'] }}</td>
                <td style="width: 160px !important;">
                    {{ $SalesHistories[$i]['chassie'] }}
                </td>
                <td class="text-danger">{{ $SalesHistories[$i]['tarif'] }}</td>    
                <td>
                <button disabled type="button" class="btn btn-success"><h4>&#x2611;</h4></button>
                </td>
=======
                <td>{{ $user_list[$i]['firstname'] }} {{ $user_list[$i]['lastname'] }}</td>
                <td>{{ $user_list[$i]['phone'] }}</td>
                <td>{{ $user_list[$i]['address'] }}</td>
                <td>{{ $date }}</td>
                <td><a href="{{ route('guichet.user.show', $user_list[$i]) }}" class="btn btn-info">VOIR</a></td>
                <td><a href="{{ route('enrollStepTwo', $user_list[$i]) }}" class="btn btn-warning">Ajouter Engin</a></td>
>>>>>>> 07c9ed991c6523d44b441abfa72a38a418869af0:resources/views/guichet/enterprise/index.blade.php
            </tr>
        @endfor


    </tbody>
    </table>
    </div>
    </div>
    <!-- <button class="btn btn-primary" onclick="generatePDF()">Generer un Rapport</button> -->
    </div>

</div>

</div>
</div>

</div>
</section>
</div>


</div>
@endsection 



