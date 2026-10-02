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
									<li class="breadcrumb-item"><a href="javascript:">Hasil Produksi</a></li>
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
								<form method="POST" action="{{ route('admin.store_hasil_monitoring') }}">
									@csrf
									<input type="hidden" name="id_monitoring" value="{{$id_monitoring}}">
									<input type="hidden" name="tgl_laporan" value="{{$tgl_laporan}}">
									<div class="card Recent-Users">
										<div class="card-block px-0 py-3">
											<div class="table-responsive">
												<table class="table table-hover text-center" id="">
													<thead>
														<tr class="unread">
															<th colspan="4">
																<h6 class="mb-1"><b>HASIL PRODUKSI</b></h6>
															</th>
														</tr>
														<tr class="unread">
															@foreach ($harga as $hrg)
															<th>
																<h6 class="mb-1"><b>{{ $hrg->harga }}</b></h6>
															</th>
															<input type="hidden" name="harga[]" value="{{$hrg->harga}}">
															@endforeach
														</tr>
													</thead>
													<tbody>
														<tr>
															{{-- @foreach ($harga as $hrg)
															<td>
																<h6 class="mb-1">
																	<input type="number" class="form-control" placeholder=""
																	name="hasil[]" min="0" required value="0">
																</h6>
															</td>
															@endforeach --}}

															@foreach ($harga as $hrg)
															<td>
																<h6 class="mb-1">
																	@foreach ($hasil as $row)
																	@if ($row->harga == $hrg->harga)
																	{{-- <b>{{ $row->sedia }}</b> --}}
																	<input type="number" class="form-control" placeholder=""
																	name="hasil[]" min="0" required value="{{ $row->sedia }}">
																	@endif
																	@endforeach
																</h6>
															</td>
															@endforeach
														</tr>
													</tbody>
												</table>
												<div class="text-center">
													<button type="submit" class="btn theme-bg text-center"
													style="color: white; width: 250px;"><b>SUMBIT</b></button>
												</div>
											</div>
										</div>
									</div>
								</form>
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
@endsection
