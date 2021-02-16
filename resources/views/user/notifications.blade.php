@extends('layouts.app')

@section('content')
	@if(auth()->user()->unReadNotifications()->count() != 0)
		<div class="container">
			<table class="table table-hover">
			  <thead>
			    <tr>
			      <th scope="col">Notifications non lus</th>
			      <th scope="col"></th>
			      <th scope="col"></th>
			      <th scope="col"></th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($unReadNotifications as $notification)

				    <tr>
					    <td><a href="{{ route('notification.show', ['notification' => $notification]) }}">{{ $notification->data['from'] }}</a></td>
					    <td><a href="{{ route('notification.show', ['notification' => $notification]) }}">{{ $notification->data['subject'] }}</a></td>
					    <td><a href="{{ route('notification.show', ['notification' => $notification]) }}">{{ $notification->created_at }}</a></td>
					
				    </tr>
			  	@endforeach
			  </tbody>
			</table>
		</div>
	@endif

	@if(auth()->user()->ReadNotifications()->count() != 0)
		<div class="container">
			<table class="table table-hover">
			  <thead>
			    <tr>
			      <th scope="col">Notifications lus</th>
			      <th scope="col"></th>
			      <th scope="col"></th>
			      <th scope="col"></th>
			    </tr>
			  </thead>
			  <tbody>
			  	@foreach($ReadNotifications as $notification)
			  		<a href="#">
					    <tr>
					      <td><a href="{{ route('notification.show', ['notification' => $notification]) }}">{{ $notification->data['from'] }}</a></td>
					    <td><a href="{{ route('notification.show', ['notification' => $notification]) }}">{{ $notification->data['subject'] }}</a></td>
					    <td><a href="{{ route('notification.show', ['notification' => $notification]) }}">{{ $notification->created_at }}</a></td>
					    </tr>
					</a>
			  	@endforeach
			  </tbody>
			</table>
		</div>
	@endif
@endsection