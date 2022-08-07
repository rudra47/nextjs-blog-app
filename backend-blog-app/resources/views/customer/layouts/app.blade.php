
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Saloons</title>
		<link href="{{ asset('/') }}image/pevicon.jpg" rel="icon" />

		<link rel="stylesheet" type="text/css" href="{{ asset('/') }}fontawesome/css/all.min.css" />
		<link rel="stylesheet" type="text/css" href="{{ asset('/') }}js/jquery-ui-1.8.16.custom.css" />

		<script type="text/javascript" src="{{ asset('/') }}js/jquery-1.7.1.min.js"></script>
		<script src="{{ asset('/') }}js/jquery-autocomplete-ui.js"></script>

		<link rel="stylesheet" type="text/css" href="{{ asset('/') }}datatable/jquery.dataTables.min.css" />
		<link href="{{ asset('/') }}datatable/bootstrap.css" rel="stylesheet" type="text/css">
		<link href="{{ asset('/') }}datatable/dataTables.bootstrap.css" rel="stylesheet">

		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="stylesheet" type="text/css" href="main.css" />

		<script src="{{ asset('/') }}js/common.js" type="text/javascript"></script>
		<script src="{{ asset('/') }}js/bootstrap.min.js" type="text/javascript"></script>

		<script src="{{ asset('/') }}js/select_min.js" type="text/javascript"></script>
		<link rel="stylesheet" type="text/css" href="{{ asset('/') }}js/select_min.css"/>

		<link href="https://fonts.googleapis.com/css?family=Baloo+Da+2:400,500,600,700&display=swap&subset=bengali" rel="stylesheet">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


	<style type="text/css">
		body { font: normal 10pt Helvetica, Arial; }
		#map-canvas { width: 100%; height:calc(100% - 55px); border: 0px; padding: 0px; position: absolute; top: 55px; }
		/*#map-canvas { width: 100%; height:500px; border: 0px; padding: 0px;}*/
		.gm-style .gm-style-iw-c {
			width: 330px !important;
			max-width: 330px !important;
		}
		.gm-style .gm-style-iw-d {
			width: 100% !important;
			max-width: 100% !important;
		}
		.mapInfo span {
			display: inline-block;
			width: 90px;
		}

		.pull-right {
			float: right!important;
			width: 100%;
		}
		.btn-default {
			color: #000;
			background-color: #fff;
			border-color: orange;
			width: 100%;
			background: orange;
			font-size: 20px;
			font-weight: bold;
		}

		.navbar {
			border: none !important;
			border-radius: 0 !important;
		}

	</style>

@stack('css')

</head>

<body>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
		  <div class="navbar-header">
			<a class="navbar-brand" href="{{ route('home') }}">WebSiteName</a>
		  </div>
		  <ul class="nav navbar-nav">
			<li><a href="{{ route('home') }}">Home</a></li>
			@if(auth()->check())
				<li><a href="#">My Bookings</a></li>
				<li><a href="{{ route('profile') }}">My Profile</a></li>
			@endif
			<li><a href="{{ route('map') }}">Map</a></li>
		  </ul>
		  <ul class="nav navbar-nav navbar-right">
			<li><a href="{{ route('saloon.apply') }}" style="border: 1px solid rgb(20, 155, 50); border-radius: 5px; padding-top: 5px; padding-bottom: 5px; margin-top: 7px;">Apply as a Saloon</a></li>
			@if(auth()->check())
				<li><a href="#" onclick="event.preventDefault();" style="cursor: auto;">Welcome, {{ auth()->user()->name }}</a></li>
				<li>
					<a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span class="glyphicon glyphicon-log-in"></span> Logout</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
						@csrf
					</form>
				</li>
			@else
				<li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
				<li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			@endif
		  </ul>
		</div>
	</nav>

	@yield('content')

<!---------------- Java Scripts for Map  ----------------->
<!--<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCioD60UKGbPyLAFK8MoAH9UqySjVb50tw&v=3&language=en"></script>-->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDuSN0u2fpgle4eYZ1kxPHmTA8maKJynYE&sensor=false" /></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>


@stack('scripts')
