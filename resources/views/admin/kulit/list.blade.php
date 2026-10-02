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
									<h5 class="m-b-10">Kulit</h5>
								</div>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
									<li class="breadcrumb-item"><a href="javascript:">Data Kulit</a></li>
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
										<div class="row">
											<div class="col-xl-2 col-md-2">
												<a href="{{ route('admin.input_kulit') }}" class="btn theme-bg" style="color: white; width: 100%;">Input Data Kulit</a>
											</div>
											<form method="get" action="">
												<div class="row">
													<div class="col-xl-6 col-md-6">
														<div class="form-group">
															<input type="text" required class="form-control datepicker" placeholder="Tanggal Laporan" name="tgl" required="required" value="{{$get->tgl}}">
														</div>
													</div>
													
													<div class="col-xl-4 col-md-4">
														<button type="submit" class="btn theme-bg" style="color: white; width: 100%;">Lihat</button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-12 col-md-12">
								<div class="card Recent-Users">
									<div class="card-header">
										@if ($get->tgl)
										<h5>{{ Carbon\Carbon::parse($get->tgl)->translatedFormat('d F Y') }}</h5>
										@endif

										@if (count($data) != 0)
										<br><br>
										<div class="col-xl-2 col-md-2">
											<a href="{{ URL::to('admin/edit_data_kulit?tgl='.$get->tgl) }}" class="btn theme-bg" style="color: white; width: 100%;">Update Data</a>
										</div>
										@endif
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
															<h6 class="mb-1"><b>Nama</b></h6>
														</th>                                              
														<th>
															<h6 class="mb-1"><b>Kulit</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Harga</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Bayar</b></h6>
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
															<h6 class="mb-1">{{$row->name}}</h6>
														</td>  
														<td>
															<h6 class="mb-1">{{$row->kulit}}</h6>
														</td> 
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format($row->harga,0,',','.') }},-</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format($row->bayar,0,',','.') }},-</h6>
														</td>
														<td>
															<div class="dropdown">
																<button class="theme-bg btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	Aksi
																</button>
																<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
																	<a class="dropdown-item" href="{{ URL::to('admin/detail_kulit?id_pelanggan='.$row->id_pelanggan.'&tgl='.$get->tgl) }}">Detail</a>
																	<a class="dropdown-item" href="{{ URL::to('admin/edit_kulit?id_pelanggan='.$row->id_pelanggan.'&tgl='.$get->tgl) }}">Bayar</a>
																</div>
															</div>
														</td>    
													</tr>
													@endforeach
													<tr class="unread">   
														<td colspan="2">
															<h6 class="mb-1"></h6>
														</td> 
														<td>
															<h6 class="mb-1"><b>{{$jml_kulit}}</b></h6>
														</td>  
														<td style="text-align: right;">
															<h6 class="mb-1"><b>Rp {{ number_format($jml_harga,0,',','.') }},-</b></h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1"><b>Rp {{ number_format($jml_bayar,0,',','.') }},-</b></h6>
														</td>
														<td>
														</td>   
													</tr>
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