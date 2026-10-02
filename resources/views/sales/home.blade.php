@extends('../layouts.front')
@section('content')
<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
	<div class="pcoded-wrapper">
		<div class="pcoded-content">
			<div class="pcoded-inner-content">
				<!-- [ breadcrumb ] start -->
				<div class="page-header">
					<div class="page-block">
						<div class="row align-items-center">
							<div class="col-md-12">
								<div class="page-header-title">
									<h5 class="m-b-10">Laporan</h5>
								</div>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
									<li class="breadcrumb-item"><a href="javascript:">Laporan Harian</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!-- [ breadcrumb ] end -->
				<div class="main-body">
					<div class="page-wrapper">
						<!-- [ Main Content ] start -->
						<div class="row">
							<!--[ Recent Users ] start-->
							<div class="col-xl-12 col-md-12">
								<div class="card Recent-Users">
									<form method="POST" action="{{ route('sales.lapor') }}">
										@csrf
										<div class="card-header">
											@if ($message = Session::get('warning'))
											<br>
											<div class="alert alert-warning alert-block">
												<button type="button" class="close" data-dismiss="alert">×</button>
												<strong>{{ $message }}</strong>
											</div>
											@endif
											@if ($message = Session::get('success'))
											<br>
											<div class="alert alert-success alert-block">
												<button type="button" class="close" data-dismiss="alert">×</button>
												<strong>{{ $message }}</strong>
											</div>
											@endif
											<div class="row">
												<div class="col-xl-4 col-md-4">
													<div class="form-group">
														{{-- <label>Pilih Tanggal Laporan</label> --}}
														<input type="text" required class="form-control datepicker"
														placeholder="Tanggal Laporan" name="tgl_laporan"
														required="required" value="{{ old('tgl_laporan') }}">
													</div>
												</div>
												<div class="col-xl-3 col-md-3">
													<button type="submit" class="btn theme-bg"
													style="color: white; width: 250px;"><b>PROSES</b></button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
							<!--[ Recent Users ] end-->
						</div>
						<!-- [ Main Content ] end -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- [ Main Content ] end -->
@endsection