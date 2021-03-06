<!DOCTYPE html>

<html class="no-js" lang="zxx">

	<head>

		@include('partials.head')

	</head>

	<body class="full-wrapper">

		@include('partials.header1')

		@yield('content')

	</body>

	<footer>

		@include('partials.footer')

	</footer>

	@include('partials.footerScript')

</html>