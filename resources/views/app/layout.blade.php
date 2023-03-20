<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>JLR Online Forms</title>

	<script>
		function fnLogOut(){
			document.getElementById("logoutForm").submit();
		}
	</script>

	<style>
		.mystyle {
			font-size : 10pt !important;
		}
	</style>

	<link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">

	<script src="{{ asset('jquery/jquery-3.5.1.min.js') }}"></script>
	<script src="{{ asset('jquery/jquery-ui.min.js') }}"></script>
	<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>


	@yield('csslib')

	@yield('jslib')
</head>
<body>
	<form id="logoutForm" method="POST" action="{{ url('logout') }}"> @csrf</form>
	@yield('navbar')
	
	<div class="container mt-2" >
		@yield('page-content')
	</div>
</body>
</html>