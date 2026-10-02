<!DOCTYPE html>
<html lang="en">

<head>
	<title>Tempe Dangsul</title>
	<!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 10]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!-- Meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<!-- Favicon icon -->
	<link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
	<!-- fontawesome icon -->
	<link rel="stylesheet" href="{{ asset('fonts/fontawesome/css/fontawesome-all.min.css') }}">
	<!-- animation css -->
	<link rel="stylesheet" href="{{ asset('plugins/animation/css/animate.min.css') }}">
	<!-- vendor css -->
	<link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>
	<div class="auth-wrapper">
		<div class="auth-content">
			<div class="auth-bg">
				<span class="r"></span>
				<span class="r s"></span>
				<span class="r s"></span>
				<span class="r"></span>
			</div>
			<div class="card">
				<div class="card-body text-center">
					<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="feather icon-lock"></i> Logout</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
						@csrf
					</form>
				<br>
				<form method="POST" action="{{ route('sales.input') }}">
					@csrf
					<h3 class="mb-4">Bawa</h3>
					@foreach($harga as $index => $row)
					<div class="input-group mb-3">
						<input type="text" class="form-control" placeholder="{{$row->harga}}" name="bawa[]">
						<input type="hidden" name="harga[]" value="{{$row->harga}}">
					</div>
					@endforeach

					<hr>
					<h3 class="mb-4">Laku</h3>
					@foreach($harga as $index => $row)
					<div class="input-group mb-3">
						<input type="text" class="form-control" placeholder="{{$row->harga}}" name="laku[]">
					</div>
					@endforeach

					<hr>
					<h3 class="mb-4">Piutang</h3>
					<h4>{{ Auth::user()->hutang }}</h4>
					<div class="input-group mb-3">
						<input type="text" class="form-control" placeholder="Hutang Baru" name="hutang_baru">
					</div>
					<div class="input-group mb-3">
						<input type="text" class="form-control" placeholder="Pelunasan" name="pelunasan">
					</div>

					<button class="btn btn-primary shadow-2 mb-4">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Required Js -->
<script src="{{ asset('js/vendor-all.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>

</body>
</html>
