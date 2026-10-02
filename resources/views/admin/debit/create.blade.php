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
									<h5 class="m-b-10">Debit Kredit</h5>
								</div>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
									<li class="breadcrumb-item"><a href="javascript:">Input Data Debit Kredit</a></li>
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
							<div class="col-sm-12">
								<div class="card">
									<div class="card-header">
										@if ($get->tgl)
										<h5>{{ Carbon\Carbon::parse($get->tgl)->translatedFormat('d F Y')}}</h5>
										@endif
										
									</div>
									<div class="card-body">
										@if ($message = Session::get('warning'))
										<div class="alert alert-warning alert-block">
											<button type="button" class="close" data-dismiss="alert">×</button> 
											<strong>{{ $message }}</strong>
										</div>
										@endif
										<form method="POST" action="{{ route('admin.store_debit') }}">
											@csrf
											<input type="hidden" name="tgl" value="{{$get->tgl}}">
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label>Jenis</label>
														<select class="form-control" name="id_pengeluaran" required>
															<option selected="true" disabled="disabled">Pilih Pengeluaran</option>
															@foreach ($pengeluaran as $row)
															<option value="{{$row->id}}">{{$row->name}}</option>
															@endforeach
														</select>
													</div>
												</div>
												
												<div class="col-md-4">
													<div class="form-group">
														<label>Keterangan</label>
														<input type="text" class="form-control" placeholder="Keterangan" name="ket" >
													</div>
												</div>

												<div class="col-md-2">
													<div class="form-group">
														<label>Debit</label>
														<input type="number" class="form-control" placeholder="Debit" name="debit" required value="0">
													</div>
												</div>

												<div class="col-md-2">
													<div class="form-group">
														<label>Kredit</label>
														<input type="number" class="form-control" placeholder="Kredit" name="kredit" required value="0">
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
@endsection