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
									<li class="breadcrumb-item"><a href="javascript:">Detail Data Kulit</a></li>
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
												<a href="{{ URL::to('admin/edit_kulit?id_pelanggan='.$id_pelanggan.'&tgl='.$tgl) }}" class="btn theme-bg" style="color: white;">Bayar</a>
											</div>
										</div>
									</div>
									<div class="card-header">
										<h5>{{$pelanggan->name}}, {{$bulan}}</h5>
									</div>
									<div class="card-block px-0 py-3">
										<div class="table-responsive">
											<table class="table table-hover text-center" id="">
												<thead>
													<tr>
														<td colspan="4">
															<h6 class="mb-1">
																Tagihan Bulan Lalu
															</h6>
														</td>
														<td>
															<h6 class="mb-1">
																{{-- Rp {{ number_format($tagihan,0,',','.') }},- --}}

																@if ($tagihan == 0)
																<b>Rp {{ number_format($tagihan,0,',','.') }},-</b>
																@elseif($tagihan > 0)
																<b>Rp {{ number_format($tagihan,0,',','.') }},-</b><br>
																@else
																<b>Rp {{ number_format($tagihan*(-1),0,',','.') }},-</b><br>
																<i>(Tabungan)</i>
																@endif
															</h6>
														</td>
													</tr>
													<tr class="unread">   
														<th>
															<h6 class="mb-1"><b>Tanggal</b></h6>
														</th> 
														<th>
															<h6 class="mb-1"><b>Kulit</b></h6>
														</th> 
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Harga</b></h6>
														</th> 
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Bayar</b></h6>
														</th> 
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Tagihan</b></h6>
														</th> 
													</tr> 
												</thead>
												<tbody> 
													@php
													$total_tagihan = 0;
													$total_kulit = 0;
													$total_harga = 0;
													$total_bayar = 0;
													@endphp
													@foreach($data as $i => $row)
													<tr>
														<td>
															<h6 class="mb-1">
																{{ Carbon\Carbon::parse($row->tgl)->translatedFormat('d F Y')}}
															</h6>
														</td>
														<td>
															<h6 class="mb-1">
																{{$row->kulit}}
																@php
																$total_kulit = $total_kulit + $row->kulit;
																@endphp
															</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">
																Rp {{ number_format($row->harga,0,',','.') }},-
																@php
																$total_harga = $total_harga + $row->harga;
																@endphp
															</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">
																Rp {{ number_format($row->bayar,0,',','.') }},-
																@php
																$total_bayar = $total_bayar + $row->bayar;
																@endphp
															</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">
																@if ($row->bayar == 0)
																Rp {{ number_format($row->harga,0,',','.') }},-
																@else
																Rp {{ number_format($row->tagihan,0,',','.') }},-
																@endif
															</h6>
														</td>
													</tr>
													@php
													$total_tagihan = ($total_harga+$total_tagihan) - $total_bayar;
													@endphp
													@endforeach
													<tr class="unread">   
														<th>
															<h6 class="mb-1"><b>Total</b></h6>
														</th> 
														<th>
															<h6 class="mb-1"><b>{{$total_kulit}}</b></h6>
														</th> 
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Rp {{ number_format(($total_harga),0,',','.') }},-</b></h6>
														</th> 
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Rp {{ number_format($total_bayar,0,',','.') }},-</b></h6>
														</th> 
														<th style="text-align: right;">
															<h6 class="mb-1">
																@php
																$tot = ($total_harga+$tagihan)-$total_bayar
																@endphp
																{{-- <b>Rp {{ number_format($tot,0,',','.') }},-</b> --}}
																@if ($tot == 0)
																<b>Rp {{ number_format($tot,0,',','.') }},-</b>
																@elseif($tot > 0)
																<b>Rp {{ number_format($tot,0,',','.') }},-</b><br>
																@else
																<b>Rp {{ number_format($tot*(-1),0,',','.') }},-</b><br>
																<i>(Tabungan)</i>
																@endif
															</h6>
														</th> 
													</tr> 
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