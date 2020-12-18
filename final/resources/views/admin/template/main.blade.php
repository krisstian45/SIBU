<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<title>@yield('title', 'Default') | Panel de Administración</title>
	<link rel="stylesheet" type="text/css" href="{{ asset('plugin/bootstrap/css/bootstrap.css') }}">
</head>
<body>
	@include('admin/template/partials/nav')
	<section>
		<div class="panel panel-default">
	  		<div class="panel-heading">
	    		<h3 class="panel-title">@yield('title')</h3>
	  		</div>
	  		<div class="panel-body">
	  			@include('flash::message')
				@include('admin/template/partials/errors')
	    		@yield('content')
	  		</div>
		</div>
	</section>

	<br />

	<footer>
		@include('admin/template/partials/footer')
	</footer>
	<script type="text/javascript" src="{{ asset('plugin/jquery/js/jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('plugin/bootstrap/js/bootstrap.js') }}"></script>
</body>
</html>
