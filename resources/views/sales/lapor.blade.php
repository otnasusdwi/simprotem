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
									<form method="POST" action="{{ route('sales.validasi') }}">
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
												<div class="col-xl-3 col-md-3">
													<h5>{{ $tgl }}</h5>
												</div>
											</div>
										</div>
										<input type="hidden" name="tgl_laporan" value="{{ $tgl_laporan }}">
										<div class="card-block px-0 py-3">
											<div class="table-responsive">
												<table class="table table-hover">
													<thead>
														<tr class="unread">
															<th style="width: 10%;">
																<h6 class="mb-1"><b>Harga</b></h6>
															</th>
															<th style="width: 5%;">
																<h6 class="mb-1"><b>Sedia</b></h6>
															</th>
															<th style="width: 5%;">
																<h6 class="mb-1"><b>Tambah</b></h6>
															</th>
															<th style="width: 20%;">
																<h6 class="mb-1"><b>Bawa</b></h6>
															</th>
															<th style="width: 20%;">
																<h6 class="mb-1"><b>Tambah</b></h6>
															</th>
															<th style="width: 20%;">
																<h6 class="mb-1"><b>Sisa Muda</b></h6>
															</th>
															<th style="width: 20%;">
																<h6 class="mb-1"><b>Sisa Tua</b></h6>
															</th>
														</tr>
													</thead>
													<tbody>
														@foreach($harga as $i => $row)
														<tr>
															<td>
																<h6 class="mb-1"><b>Rp
																	{{ number_format($row->harga,0,',','.') }}</b>
																</h6>
																<input type="hidden" name="harga[]"
																value="{{$row->harga}}" value="0">
															</td>
															<td>
																<h6 class="mb-1" style="text-align: center;">
																	@if ($sedia)
																	{{ $sedia[$i] }}
																	<input type="hidden" class="form-control" placeholder=""
																	name="sedia[]" min="0" required value="{{ $sedia[$i] }}">
																	@endif
																</h6>
															</td>
															<td>
																<h6 class="mb-1" style="text-align: center;">
																	@if ($tambah)
																	{{ $tambah[$i] }}
																	@endif
																</h6>
															</td>
															<td>
																<input type="number" class="form-control" placeholder=""
																name="bawa[]" min="0" required value="0">
															</td>
															<td>
																<input type="number" class="form-control" placeholder=""
																name="tambah[]" min="0" required value="0">
															</td>
															<td>
																<input type="number" class="form-control" placeholder=""
																name="sisa_muda[]" min="0" required value="0">
															</td>
															<td>
																<input type="number" class="form-control" placeholder=""
																name="sisa_tua[]" min="0" required value="0">
															</td>
														</tr>
														@endforeach
													</tbody>
												</table>
												<br>
											</div>
											<br><br><br>
											<div class="table-responsive">
												<table class="table table-hover">
													<thead>
														<tr>
															<th colspan="2" class="text-center">
																<h6 class="mb-1"><b>PIUTANG ( Rp
																	{{ number_format(Auth::user()->piutang,0,',','.') }},-
																)</b></h6>
															</th>
														</tr>
														<tr>
															<th class="text-center">
																<h6 class="mb-1"><b>HUTANG BARU</b></h6>
															</th>
															<th class="text-center">
																<h6 class="mb-1"><b>PELUNASAN</b></h6>
															</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td>
																<input type="number" class="form-control"
																name="hutang_baru" min="0"
																value="{{ old('hutang_baru', '0') }}" required="">
															</td>
															<td>
																<input type="number" class="form-control"
																name="pelunasan" min="0"
																value="{{ old('pelunasan', '0') }}" required="">
															</td>
														</tr>
													</tbody>
												</table>
											</div>
											<br>
											<div class="text-center">
												<button type="submit" class="btn theme-bg"
												style="color: white; width: 250px;"><b>PROSES</b></button>
											</div>
										</div>
										<div id="myModal" tabindex="-1" role="dialog" class="modal fade">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-body">
														<div class="text-center">
															<div class="text-danger"><span
																class="modal-main-icon mdi mdi-close-circle-o"></span>
															</div>
															<h3>Perhatian!</h3>
															<p>Apakah data Anda sudah benar?</p>
														</div>
													</div>
													<div class="modal-footer">
														<div class="text-center">
															<div class="xs-mt-50">
																<button type="button" class="btn btn-default"
																data-dismiss="modal">Batal</button>
																<button type="button"
																class="btn btn-primary">Submit</button>
															</div>
														</div>
													</div>
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