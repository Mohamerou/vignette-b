@extends('layouts.app')

@section('content')
	<div class="container col-8 border-top border-primary py-3">
		<div class="alert alert-warning" role="alert">
		  <h4>Notice:</h4> Vous allez accepter la demande de tranfert d'un de vos engin ! <br>
		</div>
		@if(Session::has('error'))

            <p class="alert
            {{ Session::get('alert-class', 'alert-danger') }}">{{Session::get('error') }}</p>

        @endif

        @if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif
			@if(Session::has('error'))

                <p class="alert
                {{ Session::get('alert-class', 'alert-danger') }}">{{Session::get('error') }}</p>

            @endif

            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Infos Moto</th>
                    <th scope="col">Nouveau Proprietaire</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                        {{ $data['enginMarque'] }} {{ $data['enginType'] }}
                        <br>
                        {{ $data['enginChassie'] }}
                    </td>
                    <td>
                        {{ $data['newOwner'] }} 
                        <br>
                        {{ $data['newOwnerPhone'] }} 
                    </td>
                    <td><a class="btn btn-success " id="show_confirm" onclick="return confirm('Voulez-vous vraiment transferer cet engin ?')" href="{{ route('validateTransfert', $data['notificationId']) }}">VALIDER LE TRANSFERT</a></td>
                  </tr>
                </tbody>
              </table>
	</div>



    {{-- Popup for confirm transfert  --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

<script type="text/javascript">

 

function show_confirm() {

          var form =  $(this).closest("form");

          var name = $(this).data("name");

          event.preventDefault();

          swal({

              title: `Are you sure you want to delete this record?`,

              text: "If you delete this, it will be gone forever.",

              icon: "warning",

              buttons: true,

              dangerMode: true,

          })

          .then((willDelete) => {

            if (willDelete) {

              form.submit();

            }

          });

      });

  

</script>
@endsection