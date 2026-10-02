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
									<h5 class="m-b-10">Debit</h5>
								</div>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
									<li class="breadcrumb-item"><a href="javascript:">Debit Kredit Bulan {{ Carbon\Carbon::parse($tgl)->translatedFormat('F')}}</a></li>
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
											<div class="col-xl-3 col-md-3">
												<div class="form-group">
													<a href="{{ URL::to('admin/debit?tgl='.$get->tgl) }}" class="btn theme-bg" style="color: white; width: 100%;"><i class="feather icon-arrow-left"></i> Debit Kredit {{ Carbon\Carbon::parse($get->tgl)->translatedFormat('d F Y')}}</a>
												</div>
											</div>
											<div class="col-xl-3 col-md-3">
												<div class="form-group">
													<a href="{{ route('admin.cetakkredit', ['tgl' => request('tgl')]) }}" class="btn btn-danger" style="color: white; width: 100%;" target="_blank">
                                          <i class="feather icon-file-text"></i> Download PDF
                                       </a>
												</div>
											</div>
										</div>
										<br />
										<div class="row">
											<div class="col-xl-6 col-md-6">
												<h5>Debit Kredit {{ \Carbon\Carbon::parse(request('tgl'))->translatedFormat('F Y') }}</h5>
											</div>
										</div>
									</div>
									<div class="card-block px-0 py-3">
										<div class="table-responsive">
											<table class="table table-hover" id="">
												<thead>
													<tr class="unread">   
														<th>
															<h6 class="mb-1"><b>Keterangan</b></h6>
														</th> 
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Debit</b></h6>
														</th> 
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Kredit</b></h6>
														</th> 
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Saldo</b></h6>
														</th> 
													</tr> 
												</thead>
												<tbody> 
													<tr>
														<td>
															<h6 class="mb-1">
																Saldo Dalam 1 Bulan
															</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format($debit,0,',','.') }},-</h6>
														</td>
														<td>
															<h6 class="mb-1">
															</h6>
														</td>
														<td>
															<h6 class="mb-1">
															</h6>
														</td>
													</tr>
													<tr>
														<td>
															<h6 class="mb-1">
																Pengeluaran Pabrik 1 Bulan
															</h6>
														</td>
														<td>
															<h6 class="mb-1">
															</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format($kredit,0,',','.') }},-</h6>
														</td>
														<td>
															<h6 class="mb-1">
															</h6>
														</td>
													</tr>
													<tr>
														<td>
															<h6 class="mb-1">
																Pemakain Dele 1 Bulan
															</h6>
														</td>
														<td>
															<h6 class="mb-1">
															</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format($pemakaian_kedelai,0,',','.') }},-</h6>
														</td>
														<td>
															<h6 class="mb-1">
															</h6>
														</td>
													</tr>
													<tr>
														<td>
															<h6 class="mb-1">
																<b>Laba</b>
															</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1"><b>Rp {{ number_format($debit,0,',','.') }},-</b></h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1"><b>Rp {{ number_format($kredit+$pemakaian_kedelai,0,',','.') }},-</b></h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1"><b>Rp {{ number_format($debit-($kredit+$pemakaian_kedelai),0,',','.') }},-</b></h6>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-12 col-md-12">
								<div class="card Recent-Users">
									<div class="card-header">
										<div class="row">
											<div class="col-xl-6 col-md-6">
												<h5>Rincian Anggaran Bulanan</h5>
											</div>
										</div>
									</div>
									<div class="card-block px-0 py-3">
										<div class="table-responsive">
											<table class="table table-hover" id="">
												<thead>
													<tr class="unread">   
														<th>
															<h6 class="mb-1"><b>Pengeluaran</b></h6>
														</th> 
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Jumlah</b></h6>
														</th> 
														<th class="text-center">
															<h6 class="mb-1"><b>Aksi</b></h6>
														</th> 
													</tr> 
												</thead>
												<tbody>
													@php
													$total_rincian = 0;
													$tgl = $get->tgl;
													@endphp
													@for ($i = 0; $i < count($rincian); $i++)
													@php
														$id = $rincian[$i]['id'];
													@endphp
													{{-- @if ($rincian[$i]['id'] != 11) --}}
													<tr>
														<td>
															<h6 class="mb-1">
																{{$rincian[$i]['name']}}
															</h6>
														</td>
														<td style="text-align: right;">
															@if ($rincian[$i]['id'] != 11)
																<h6 class="mb-1">Rp {{ number_format($rincian[$i]['kredit'],0,',','.') }},-</h6>
															@else
																<h6 class="mb-1">{{ $rincian[$i]['qty'] }}</h6>
															@endif
														</td>
														<td class="text-center">
															{{-- @if ($rincian[$i]['kredit'] != 0 && $rincian[$i]['id'] != 11) --}}
															@if ($rincian[$i]['kredit'] != 0 )
																<a href="{{ URL::to('admin/detail_pengeluaran?tgl='.$tgl.'&id='.$id.'') }}" class="btn theme-bg" style="color: white;">Detail</a>
															@endif
														</td>
													</tr>
													@php
													if ($rincian[$i]['id'] != 11) {
													$total_rincian = $total_rincian + $rincian[$i]['kredit'];
													};
													@endphp
													
													
													{{-- @endif --}}
													@endfor
													<tr>
														<td>
															<h6 class="mb-1">
																<b>Total</b>
															</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">
																<b>
																	Rp {{ number_format($total_rincian,0,',','.') }},-
																</b>
															</h6>
														</td>
														<td></td>
													</tr>
												</tbody>
											</table>
										</div>
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