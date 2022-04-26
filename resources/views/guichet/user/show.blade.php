
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
        <h1>INFOS USAGER</h1>
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
        <h3 class="card-title">Usager: {{ $user_name }}</h3>
    </div>

    <div class="card-body p-0">
        <div class="col-md-12">
            <div class="col-md-6">
                <a class="btn btn-primary my-3" href="{{ route('guichet.user.ficheIndividuel', $user_id) }}">FICHE INDIVIDUELLE</a>
            </div>
            <div class="col-md-6">
                <a class="btn btn-info my-3" href="{{ route('guichet.user.engin.nouvel', $user_id) }}">NOUVEL ENGIN</a>
            </div>
        </div>
        
    <table id="example" class="table table-striped table-hover table-bordered">
    <thead>
    <tr>
    <th>MARQUE</th>
    <th>TYPE</th>
    <th>CHASSIE</th>
    <th>PERTE</th>
    <th>VIGNETTE</th>
    </tr>
    </thead>
    <tbody>

        @for($i=0; $i < count($user_data); $i++)
            <tr>
                <td>{{ $user_data[$i]['engin_marque'] }}</td>
                <td>{{ $user_data[$i]['engin_type'] }}</td>
                <td>{{ $user_data[$i]['engin_chassie'] }}</td>
                @if($user_data[$i]['signaler_perdue'])
                    <td class="text-danger">
                        <a href="{{ route('guichet.user.engin.annuler', $user_data[$i]['engin_chassie']) }}" class="btn btn-danger">ANNULER DECLARATION</a>
                    </td>
                @else
                    <td class="text-success h5">
                        <a href="{{ route('guichet.user.engin.signaler_perdue', $user_data[$i]['engin_chassie']) }}" class="btn btn-warning">FAIRE UNE DECLARATION</a>
                    </td>
                @endif
                @if($user_data[$i]['vignette_status'])
                    <td class="text-success">A JOUR</td>
                @else
                    <td class="text-danger"> RENOUVELLER </td>
                @endif
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



