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
									<li class="breadcrumb-item"><a href="javascript:">Detail Data Setoran</a></li>
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
										@if ($message = Session::get('warning'))
										<div class="alert alert-warning alert-block">
											<button type="button" class="close" data-dismiss="alert">×</button> 
											<strong>{{ $message }}</strong>
										</div>
										@endif
										<div class="row">
											<div class="col-xl-2 col-md-2">
												<button  onclick="history.back()" class="btn theme-bg" style="color: white;">Kembali</button>
											</div>
										</div>
									</div>
									<div class="card-header">
										<h6>{{ $data[0]->name }}, Data Setoran tanggal {{ $get->from }} sampai {{ $get->to }}</h6>
                              <br>
                              <h5><b>TOTAL SETORAN :</b> Rp {{ number_format($setoran,0,',','.') }},- | <b>RATA-RATA :</b> Rp {{ number_format($setoran/count($data),0,',','.') }},- | <b>SUBSIDI :</b> Rp {{ number_format(5000*count($data),0,',','.') }},-</h5>
									</div>
									<div class="card-block px-0 py-3">
										<div class="table-responsive">
											<table class="table table-hover text-center" id="">
												<thead>
													<tr class="unread">   
														<th>
															<h6 class="mb-1"><b>No</b></h6>
														</th> 
														<th>
															<h6 class="mb-1"><b>Tanggal Laporan</b></h6>
														</th> 
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Jumlah Laku</b></h6>
														</th>
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Setoran</b></h6>
														</th> 
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Hutang Baru</b></h6>
														</th> 
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Pelunasan</b></h6>
														</th>  
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Piutang</b></h6>
														</th> 
													</tr> 
												</thead>
												<tbody>
													@foreach($data as $i => $row)
                                       <tr>
                                          <td>{{ $i+1 }}</td>
                                          <td>{{ $row->tgl_laporan }}</td>
                                          <td style="text-align: right;">Rp {{ number_format($row->jumlah_laku,0,',','.') }},-</td>
                                          <td style="text-align: right;">Rp {{ number_format($row->setoran,0,',','.') }},-</td>
                                          <td style="text-align: right;">Rp {{ number_format($row->hutang_baru,0,',','.') }},-</td>
                                          <td style="text-align: right;">Rp {{ number_format($row->pelunasan,0,',','.') }},-</td>
                                          <td style="text-align: right;">Rp {{ number_format($row->piutang,0,',','.') }},-</td>
                                       </tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!--[ Recent karyawan ] end-->
						</div>
						<!-- [ Main Content ] end -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection