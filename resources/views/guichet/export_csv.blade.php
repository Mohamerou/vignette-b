@extends ('layouts.admin')

@section('content')

<div class="content-wrapper">

<section class="content-header">
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
    <h1>IMPRESSION PVC</h1>
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
    <h3 class="card-title">IMPRESSION SUR PVC</h3>
    </div>

    <div class="card-body p-0 text-center">
    <table>
        <thead>
        <tr>
            <th></th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td class="display-4">{{ $chassie }}</td>
            </tr>
        </tbody>
    </table>

    <iframe width="1080" height="660" src="https://docs.google.com/spreadsheets/d/13li-yQ-D0hDV1L4512TcxSXz99MI4HKT-KRraZXY-Vg/edit#gid=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
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