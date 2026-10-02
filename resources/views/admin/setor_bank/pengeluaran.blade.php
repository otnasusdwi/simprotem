@extends('../layouts.app')
@section('content')
<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
	<div class="pcoded-wrapper">
		<div class="pcoded-content">
			<div class="pcoded-inner-content">
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
												<h4>Detail Anggaran Bulanan</h4>
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
														<th>
															<h6 class="mb-1"><b>Tanggal Setor</b></h6>
														</th> 
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Jumlah</b></h6>
														</th> 
													</tr> 
												</thead>
												<tbody>
													@php
													$total_data = 0;
													$tgl = $get->tgl;
													@endphp
													@for ($i = 0; $i < count($data); $i++)
													<tr>
														<td>
															<h6 class="mb-1">
																{{$data[$i]->name}} <b><i>( {{$data[$i]->ket}} )</i></b>
															</h6>
														</td>
														<td>
															<h6 class="mb-1">
																{{ Carbon\Carbon::parse($data[$i]->tgl_setor)->translatedFormat('d F Y') }}
															</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format($data[$i]->kredit,0,',','.') }},-</h6>
														</td>
													</tr>
													@php
													$total_data = $total_data + $data[$i]->kredit;
													@endphp
													@endfor
													<tr>
														<td>
															<h6 class="mb-1">
																<b>Total</b>
															</h6>
														</td>
														<td></td>
														<td style="text-align: right;">
															<h6 class="mb-1">
																<b>
																	Rp {{ number_format($total_data,0,',','.') }},-
																</b>
															</h6>
														</td>
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