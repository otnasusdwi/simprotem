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
									<h5 class="m-b-10">Kedelai</h5>
								</div>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
									<li class="breadcrumb-item"><a href="javascript:">Edit Data Kedelai</a></li>
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
								<form method="POST" action="{{ route('admin.update_kedelai') }}">
									@csrf
									<div class="card Recent-Users">
										<div class="card-header">
											@if ($message = Session::get('warning'))
											<div class="alert alert-warning alert-block">
												<button type="button" class="close" data-dismiss="alert">×</button> 
												<strong>{{ $message }}</strong>
											</div>
											@endif
											<div class="card-header">
												<h5>
													@if ($bulan == '01')
													Januari, {{$tahun}}
													@elseif ($bulan == '02')
													Februari, {{$tahun}}
													@elseif ($bulan == '03')
													Maret, {{$tahun}}
													@elseif ($bulan == '04')
													April, {{$tahun}}
													@elseif ($bulan == '05')
													Mei, {{$tahun}}
													@elseif ($bulan == '06')
													Juni, {{$tahun}}
													@elseif ($bulan == '07')
													Juli, {{$tahun}}
													@elseif ($bulan == '08')
													Agustus, {{$tahun}}
													@elseif ($bulan == '09')
													September, {{$tahun}}
													@elseif ($bulan == '10')
													Oktober, {{$tahun}}
													@elseif ($bulan == '11')
													November, {{$tahun}}
													@else
													Desember, {{$tahun}}
													@endif
												</h5>
												<input type="hidden" name="bulan" value="{{$bulan}}">
												<input type="hidden" name="tahun" value="{{$tahun}}">
											</div>
											<div class="row">
												<div class="col-xl-2 col-md-2">
													<div class="form-group">
														<label>Harga</label>
														<input type="number" class="form-control" placeholder="Harga"
														name="harga" min="0" required value="{{$data[0]->harga}}">
													</div>
												</div>
												<div class="col-xl-2 col-md-2">
													<div class="form-group">
														<label>Sisa Bulan Lalu (30/31)</label>
														<input type="number" class="form-control" placeholder="Sisa"
														name="sisa" min="0" required value="{{$data[0]->sisa_lalu}}">
													</div>
												</div>
											</div>
										</div>
										<div class="card-block px-0 py-3">
											<div class="table-responsive">
												<table class="table table-hover text-center" id="">
													<thead>
														<tr class="unread">   
															<th>
																<h6 class="mb-1"><b>Tanggal</b></h6>
															</th> 
															<th>
																<h6 class="mb-1"><b>Tempe (Sak)</b></h6>
															</th> 
															<th>
																<h6 class="mb-1"><b>Dele Datang</b></h6>
															</th> 
														</tr> 
													</thead>
													<tbody> 
														@foreach($data as $i => $row)
														@php
														$no = $i+1;
														@endphp
														<tr>
															<input type="hidden" name="id[]" value="{{$row->id}}">
															<td>
																<h6 class="mb-1">
																	<b>{{$no}}</b>
																</h6>
															</td>
															<td>
																<h6 class="mb-1">
																	<input type="number" class="form-control" placeholder="Sak" name="tempe[]" step="0.01" min="0" required value="{{$row->tempe}}">
																</h6>
															</td>
															<td>
																<h6 class="mb-1">
																	<input type="number" class="form-control" placeholder="Sak" name="datang[]" step="0.01" min="0" required value="{{$row->datang}}">
																</h6>
															</td>
														</tr>
														@endforeach
													</tbody>
												</table>
											</div>
											<br>
											<div class="text-center">
												<button type="submit" class="btn theme-bg"
												style="color: white; width: 250px;"><b>SUMBIT</b></button>
											</div>
										</div>
									</div>
								</form>
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