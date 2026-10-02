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
									<h5 class="m-b-10">Gaji</h5>
								</div>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
									<li class="breadcrumb-item"><a href="javascript:">Data Gaji</a></li>
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
												<a href="{{ route('admin.input_gaji') }}" class="btn theme-bg" style="color: white; width: 100%;">Input Gaji</a>
											</div>
											<form method="get" action="">
												<div class="row">
													<div class="col-xl-4 col-md-4">
														<div class="form-group">
															<select class="form-control" id="exampleFormControlSelect1" name="bulan">
																<option value="Januari" @if($get->bulan == "Januari") selected @endif>Januari</option>
																<option value="Februari" @if($get->bulan == "Februari") selected @endif>Februari</option>
																<option value="Maret" @if($get->bulan == "Maret") selected @endif>Maret</option>
																<option value="April" @if($get->bulan == "April") selected @endif>April</option>
																<option value="Mei" @if($get->bulan == "Mei") selected @endif>Mei</option>
																<option value="Juni" @if($get->bulan == "Juni") selected @endif>Juni</option>
																<option value="Juli" @if($get->bulan == "Juli") selected @endif>Juli</option>
																<option value="Agustus" @if($get->bulan == "Agustus") selected @endif>Agustus</option>
																<option value="September" @if($get->bulan == "September") selected @endif>September</option>
																<option value="Oktober" @if($get->bulan == "Oktober") selected @endif>Oktober</option>
																<option value="November" @if($get->bulan == "November") selected @endif>November</option>
																<option value="Desember" @if($get->bulan == "Desember") selected @endif>Desember</option>
															</select>
														</div>
													</div>
													<div class="col-xl-4 col-md-4">
														<div class="form-group">
															<select class="form-control" id="exampleFormControlSelect1" name="tahun">
                                                                @foreach ($years as $year)
																   <option value="{{ $year }}"@if($get->tahun == $year) selected @endif>{{ $year }}</option>
                                                                @endforeach
															</select>
														</div>
													</div>
													<div class="col-xl-4 col-md-4">
														<button type="submit" class="btn theme-bg" style="color: white; width: 100%;">Lihat</button>
													</div>
												</div>
											</form>
											@if (count($data[0]) != 0)
											<div class="col-xl-2 col-md-2">
												<a href="{{ URL::to('admin/edit_gaji?bulan='.$get->bulan.'&tahun='.$get->tahun) }}" class="btn theme-bg" style="color: white; width: 100%;">Edit</a>
											</div>
											@endif
										</div>
									</div>
									<div class="card-header">
										<h5>Tanggal 1</h5>
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
															<h6 class="mb-1"><b>Nama Karyawan</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Masuk</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Gaji</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Jumlah</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Hutang & Bon</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Jaga Malam</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Terima</b></h6>
														</th>
													</tr>
												</thead>
												<tbody>
													@php
													$jml_hutang = 0;
													$jml_terima = 0;
													@endphp
													@foreach($data[0] as $index => $row)
													<tr class="unread">
														<td>
															<h6 class="mb-1">{{ $index+1 }}</h6>
														</td>
														<td>
															<h6 class="mb-1">{{$row->name}}</h6>
														</td>
														<td>
															<h6 class="mb-1">{{$row->masuk}}</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format($row->gaji_karyawan,0,',','.') }},-</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format(($row->masuk*$row->gaji_karyawan),0,',','.') }},-</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format($row->hutang,0,',','.') }},-</h6>
															@php
															$jml_hutang = $jml_hutang + $row->hutang;
															@endphp
														</td>
														<td>
															<h6 class="mb-1">{{$row->jaga_malam}}</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format((($row->masuk*$row->gaji_karyawan)+$row->jaga_malam) - $row->hutang,0,',','.') }},-</h6>
															@php
															$jml_terima = $jml_terima + (($row->masuk*$row->gaji_karyawan)+$row->jaga_malam) - $row->hutang;
															@endphp
														</td>
													</tr>
													@endforeach
													<tr class="unread">
														<th>
															<h6 class="mb-1"><b></b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b></b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b></b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b></b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b></b></h6>
														</th>
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Rp {{ number_format($jml_hutang,0,',','.') }},-</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b></b></h6>
														</th>
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Rp {{ number_format($jml_terima,0,',','.') }},-</b></h6>
														</th>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

									<div class="card-header">
										<h5>Tanggal 15</h5>
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
															<h6 class="mb-1"><b>Nama Karyawan</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Masuk</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Gaji</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Jumlah</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Hutang & Bon</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Jaga Malam</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Terima</b></h6>
														</th>
													</tr>
												</thead>
												<tbody>
													@foreach($data[1] as $index => $row)
													<tr class="unread">
														<td>
															<h6 class="mb-1">{{ $index+1 }}</h6>
														</td>
														<td>
															<h6 class="mb-1">{{$row->name}}</h6>
														</td>
														<td>
															<h6 class="mb-1">{{$row->masuk}}</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format($row->gaji_karyawan,0,',','.') }},-</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format(($row->masuk*$row->gaji_karyawan),0,',','.') }},-</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format($row->hutang,0,',','.') }},-</h6>
															@php
															$jml_hutang = $jml_hutang + $row->hutang;
															@endphp
														</td>
														<td>
															<h6 class="mb-1">{{$row->jaga_malam}}</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format((($row->masuk*$row->gaji_karyawan)+$row->jaga_malam) - $row->hutang,0,',','.') }},-</h6>
															@php
															$jml_terima = $jml_terima + (($row->masuk*$row->gaji_karyawan)+$row->jaga_malam) - $row->hutang;
															@endphp
														</td>
													</tr>
													@endforeach
													<tr class="unread">
														<th>
															<h6 class="mb-1"><b></b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b></b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b></b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b></b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b></b></h6>
														</th>
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Rp {{ number_format($jml_hutang,0,',','.') }},-</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b></b></h6>
														</th>
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Rp {{ number_format($jml_terima,0,',','.') }},-</b></h6>
														</th>
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
