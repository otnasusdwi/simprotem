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
									<li class="breadcrumb-item"><a href="javascript:">Data Laporan</a></li>
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
									<div class="card-header">
										<form method="get" action="">
											<div class="row">
												<input type="hidden" name="filter" value="{{$get->filter}}">
												<div class="col-xl-2 col-md-2">
													<div class="form-group">
														<input type="text" required class="form-control datepicker" placeholder="Tanggal Awal" name="from" required="required" value="{{$get->from}}"">
													</div>
												</div>
												<div class="col-xl-2 col-md-2">
													<div class="form-group">
														<input type="text" required class="form-control datepicker" placeholder="Tanggal Akhir" name="to" required="required" value="{{$get->to}}"">
													</div>
												</div>
												
												<div class="col-xl-2 col-md-2">
													<button type="submit" class="btn theme-bg" style="color: white; width: 100%;">Lihat</button>
												</div>
												
												
												<div class="col-xl-4 col-md-4">
													
												</div>
												
												<div class="col-xl-2 col-md-2">
													@if ($get->from)
													<a target="_blank" href="{{ route('sales.cetakpdf') }}?id_user={{ Auth::user()->id }}&from={{$get->from}}&to={{$get->to}}" class="btn theme-bg2" style="color: white; width: 100%;">Print</a>
													@endif
												</div>
											</div>
										</form>
									</div>
									<div class="card-block px-0 py-3">
										<div class="table-responsive">
											<table class="table table-hover text-center" id="table_id">
												<thead>
													<tr class="unread">   
														<th>
															<h6 class="mb-1"><b>No</b></h6>
														</th>                                               
														<th>
															<h6 class="mb-1"><b>Tanggal Laporan</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Jam Laporan</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Status</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Aksi</b></h6>
														</th>
													</tr>
												</thead>
												<tbody>                                                 
													@foreach($data as $index => $row)
													<tr class="unread">   
														<td>
															<h6 class="mb-1">{{ $index+1 }}</h6>
														</td>                                               
														<td>
															<h6 class="mb-1">{{ date('d-m-Y', strtotime($row->tgl_laporan)) }}</h6>
														</td>
														<td>
															<h6 class="mb-1">{{ date('H:i:s', strtotime($row->tgl_laporan)) }}</h6>
														</td>
														<td>
															<h6 class="mb-1">
																@if ( $row->status == 0 )
																<h6><strong style="color: red;">Belum Dibayar</strong></h6>
																@else
																<h6><strong style="color: green;">Sudah Dibayar</strong></h6>
																<h6>{{ date('d-m-Y H:i:s', strtotime($row->acc)) }}</h6>
																@endif
															</h6>
														</td> 
														<td>
															<div class="dropdown">
																<button class="theme-bg btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	Aksi
																</button>
																<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
																	<a class="dropdown-item" href="{{ route('sales.detail', $row->id_laporan) }}">Detail</a>
																	<a target="_blank" class="dropdown-item" href="{{ route('sales.pdf') }}?id_laporan={{ $row->id_laporan}}">Print</a>
																	<a class="dropdown-item" href="{{ route('sales.pdf-kasir') }}?id_laporan={{ $row->id_laporan}}">Print Kasir</a>
																</div>
															</div>
														</td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
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
@endsection