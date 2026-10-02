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
									<li class="breadcrumb-item"><a href="javascript:">Stok Kedelai</a></li>
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
												<a href="{{ route('admin.input_kedelai') }}" class="btn theme-bg" style="color: white; width: 100%;">Input Stok</a>
											</div>
											<form method="get" action="">
												<div class="row">
													<div class="col-xl-4 col-md-4">
														<div class="form-group">
															<select class="form-control" id="exampleFormControlSelect1" name="bulan">
																<option value="01" @if($get->bulan == "01") selected @endif>Januari</option>
																<option value="02" @if($get->bulan == "02") selected @endif>Februari</option>
																<option value="03" @if($get->bulan == "03") selected @endif>Maret</option>
																<option value="04" @if($get->bulan == "04") selected @endif>April</option>
																<option value="05" @if($get->bulan == "05") selected @endif>Mei</option>
																<option value="06" @if($get->bulan == "06") selected @endif>Juni</option>
																<option value="07" @if($get->bulan == "07") selected @endif>Juli</option>
																<option value="08" @if($get->bulan == "08") selected @endif>Agustus</option>
																<option value="09" @if($get->bulan == "09") selected @endif>September</option>
																<option value="10" @if($get->bulan == "10") selected @endif>Oktober</option>
																<option value="11" @if($get->bulan == "11") selected @endif>November</option>
																<option value="12" @if($get->bulan == "12") selected @endif>Desember</option>
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
											@if (count($data) != 0)
											<div class="col-xl-2 col-md-2">
												<a href="{{ URL::to('admin/edit_kedelai?bulan='.$get->bulan.'&tahun='.$get->tahun) }}" class="btn theme-bg" style="color: white; width: 100%;">Edit</a>
											</div>
											@endif
										</div>
									</div>
									<div class="card-block px-0 py-3">
										<div class="table-responsive">
											<table class="table table-hover text-center" id="">
												<thead>
													<tr>
														<th rowspan="2">
															<h6 class="mb-1"><b>Tanggal</b></h6>
														</th>
														<th colspan="2">
															<h6 class="mb-1"><b>Tempe</b></h6>
														</th>
														@if (Auth::user()->level == 3)
														<th>
															<h6 class="mb-1"><b>Harga Kedelai</b></h6>
														</th>
														@endif
														<th colspan="2">
															<h6 class="mb-1"><b>Dele Datang</b></h6>
														</th>
														<th colspan="2">
															<h6 class="mb-1"><b>Sisa Dele</b></h6>
														</th>
													</tr>
													<tr>
														<td><h6 class="mb-1"><b>Sak</b></h6></td>
														<td><h6 class="mb-1"><b>Kg</b></h6></td>
														@if (Auth::user()->level == 3)
														@if ($data)
														<td><h6 class="mb-1"><b>Rp {{number_format($harga)}}</b></h6></td>
														@else
														<td><h6 class="mb-1"><b></b></h6></td>
														@endif
														@endif
														<td><h6 class="mb-1"><b>Sak</b></h6></td>
														<td><h6 class="mb-1"><b>Kg</b></h6></td>
														<td><h6 class="mb-1"><b>Sak</b></h6></td>
														<td><h6 class="mb-1"><b>Kg</b></h6></td>
													</tr>
												</thead>
												<tbody>
													<tr class="unread">
														@if ($harga > 0)
														<td colspan="@if (Auth::user()->level == 2)
															5 @elseif (Auth::user()->level == 3) 6
															@endif" style="background: #f4f7fa;">
															<h6 class="mb-1">Sisa Bulan Lalu</h6>
														</td>
														<td style="background: #f4f7fa;">
															<h6 class="mb-1">{{$sisa_lalu}}</h6>
														</td>
														<td style="background: #f4f7fa;">
															<h6 class="mb-1">{{$sisa_lalu*50}}</h6>
														</td>
														@endif
													</tr>
													@php
													$jml_tempe = 0;
													$jml_kg = 0;
													$jml_harga = 0;
													$jml_dele = 0;
													$dele_kg = 0;
													$sisa = 0;
													$sisa_kg = 0;
													@endphp
													@foreach($data as $index => $row)
													<tr class="unread">
														<td>
															<h6 class="mb-1">{{$row->tgl}}</h6>
														</td>
														<td>
															<h6 class="mb-1">
																{{$row->tempe}}
																@php
																$jml_tempe = $jml_tempe + $row->tempe;
																@endphp
															</h6>
														</td>
														<td>
															<h6 class="mb-1">
																{{$row->tempe*50}}
																@php
																$jml_kg = $jml_kg + ($row->tempe*50);
																@endphp
															</h6>
														</td>
														@if (Auth::user()->level == 3)
														<td style="text-align: right;">
															<h6 class="mb-1">
																Rp {{ number_format(($row->harga*($row->tempe * 50)),0,',','.') }},-
																@php
																$jml_harga = $jml_harga + ($row->harga*($row->tempe * 50));
																@endphp
															</h6>
														</td>
														@endif
														<td>
															<h6 class="mb-1">
																{{$row->datang}}
																@php
																$jml_dele = $jml_dele + $row->datang;
																@endphp
															</h6>
														</td>
														<td>
															<h6 class="mb-1">
																{{$row->datang*50}}
																@php
																$dele_kg = $dele_kg + ($row->datang*50);
																@endphp
															</h6>
														</td>
														<td>
															<h6 class="mb-1">
																{{$row->sisa}}
																@php
																$sisa = $row->sisa;
																@endphp
															</h6>
														</td>
														<td>
															<h6 class="mb-1">
																{{$row->sisa * 50}}
																@php
																$sisa_kg = $row->sisa*50;
																@endphp
															</h6>
														</td>
													</tr>
													@endforeach
													<tr>
														<th>
															<h6 class="mb-1"><b>Jumlah</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>{{$jml_tempe}}</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>{{$jml_kg}}</b></h6>
														</th>
														@if (Auth::user()->level == 3)
														<th style="text-align: right;">
															<h6 class="mb-1">
																<b>
																	Rp {{ number_format(($jml_harga),0,',','.') }},-
																</b>
															</h6>
														</th>
														@endif
														<th>
															<h6 class="mb-1"><b>{{$jml_dele}}</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>{{$dele_kg}}</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>{{$sisa}}</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>{{$sisa_kg}}</b></h6>
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
