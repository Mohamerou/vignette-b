<!DOCTYPE html>

<html class="no-js" lang="zxx">

	<head>
		@include('sweetalert::alert')
		@include('partials.head')

	</head>

	<body class="full-wrapper">

		@include('partials.header')

		@yield('content')

	</body>

	<footer>

		@include('partials.footer')

	</footer>


</html>