@extends('../layouts.app')
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
									<h5 class="m-b-10">Monitoring</h5>
								</div>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
									<li class="breadcrumb-item"><a href="{{ route('admin.detail_monitoring', ['id_monitoring' => $id_monitoring, 'status' => 0])}}">Data Monitoring</a></li>
									<li class="breadcrumb-item"><a href="javascript:">Rendaman</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<!-- [ breadcrumb ] end -->
				<!-- [ breadcrumb ] end -->
				<div class="main-body">
					<div class="page-wrapper">
						<!-- [ Main Content ] start -->
						<div class="row">
							<div class="col-sm-12">
								<div class="card">
									<div class="card-body">
										@if ($message = Session::get('warning'))
										<div class="alert alert-warning alert-block">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>{{ $message }}</strong>
										</div>
										@endif
										<form method="POST" action="{{ route('admin.update_rendaman') }}">
											@csrf
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Rendaman 2 Hari yang lalu</label>
														<input type="number" class="form-control" value="{{$monitoring->rendaman}}" name="rendaman" required>
														<input type="hidden" name="id_monitoring" value="{{$id_monitoring}}">
													</div>
												</div>
												<div class="col-md-12">
													<button type="submit" class="btn btn-primary">Submit</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- [ Main Content ] end -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- [ Main Content ] end -->
<div id="delete" tabindex="-1" role="dialog" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="text-center">
					<div class="text-danger"><span class="modal-main-icon mdi mdi-close-circle-o"></span></div>
					<h3>Perhatian!</h3>
					<p>Anda yakin akan menghapus data?</p>
				</div>
			</div>
			<div class="modal-footer">
				<div class="text-center">
					<div class="xs-mt-50">
						<button type="button" data-dismiss="modal" class="btn btn-space btn-default">Batal</button>
						<i id="del"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
