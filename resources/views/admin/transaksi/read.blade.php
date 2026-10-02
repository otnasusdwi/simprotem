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
												<div class="col-xl-4 col-md-4">
													<div class="form-group">
														<input type="text" required class="form-control datepicker" placeholder="Tanggal Laporan" name="created_at" required="required" value="{{$get->created_at}}">
													</div>
												</div>
												
												<div class="col-xl-2 col-md-2">
													<button type="submit" class="btn theme-bg" style="color: white; width: 100%;">Lihat</button>
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
															<h6 class="mb-1"><b>Nama Sales</b></h6>
														</th>                                              
														<th>
															<h6 class="mb-1"><b>Tanggal Laporan</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Debet</b></h6>
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
															<h6 class="mb-1">{{ date('d-m-Y', strtotime($row->tgl_laporan)) }}</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format($row->setoran,0,',','.') }},-</h6>
														</td>
													</tr>
													@endforeach
													@if ($saldo != 0)
													<tr class="unread"> 
													<td colspan="3" rowspan="" headers="">
														<h6 class="mb-1"><b>SALDO</b></h6>
													</td> 
													<td style="text-align: right;">
														<h6 class="mb-1"><b>Rp {{ number_format($saldo,0,',','.') }},-</b></h6>
													</td>
													</tr>
													@endif
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