
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
        <h1>Liste des Engins enregistrer au nom de Mr./Mme {{$user->lastName }} {{$user->firstName}}</h1>
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
    <th>MARQUE</th>
    <th>TYPE</th>
    <th>CHASSIE</th>
   
    <th style="width: 170px">ACTIONS</th>
    </tr>
    </thead>
    <tbody>

        @foreach($enginList as $engin)
            <tr>
                <td>{{$engin->marque}}</td>
                <td>{{$engin->modele}}</td>
                <td>{{$engin->chassie}}</td>
              
                <td>
                    {{-- <a href="{{ route('guichet.engin.show', $user) }}" class="btn btn-info mr-1">DETAILS</a> --}}
                    <a href="{{ route('guichet.user.engin.edit', $engin->id) }}" class="btn btn-warning">EDITER</a>
                </td>
            </tr>
        @endforeach


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



