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
									<li class="breadcrumb-item"><a href="javascript:">Input Data Kedelai</a></li>
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
								<form method="POST" action="{{ route('admin.store_kedelai') }}">
									@csrf
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
													<div class="form-group">
														<label>Bulan</label>
														<select class="form-control" id="exampleFormControlSelect1" name="bulan">
															<option value="01">Januari</option>
															<option value="02">Februari</option>
															<option value="03">Maret</option>
															<option value="04">April</option>
															<option value="05">Mei</option>
															<option value="06">Juni</option>
															<option value="07">Juli</option>
															<option value="08">Agustus</option>
															<option value="09">September</option>
															<option value="10">Oktober</option>
															<option value="11">November</option>
															<option value="12">Desember</option>
														</select>
													</div>
												</div>
												<div class="col-xl-2 col-md-2">
													<div class="form-group">
														<label>Tahun</label>
														<select class="form-control" id="exampleFormControlSelect1" name="tahun">
															@foreach ($years as $year)
																<option value="{{ $year }}" @if ($year == date('Y')) selected @endif>{{ $year }}</option>
                                                            @endforeach
														</select>
													</div>
												</div>
												<div class="col-xl-2 col-md-2">
													<div class="form-group">
														<label>Harga</label>
														<input type="number" class="form-control" placeholder="Harga"
														name="harga" min="0" required>
													</div>
												</div>
												<div class="col-xl-2 col-md-2">
													<div class="form-group">
														<label>Sisa Bulan Lalu (30/31)</label>
														<input type="number" class="form-control" placeholder="Sisa"
														name="sisa" min="0" required>
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
														@for ($i = 0; $i < 31; $i++)
														@php
														$no = $i+1;
														@endphp
														<tr>
															<input type="hidden" name="tgl[]" value="{{$no}}">
															<td>
																<h6 class="mb-1">
																	<b>{{$no}}</b>
																</h6>
															</td>
															<td>
																<h6 class="mb-1">
																	<input type="number" class="form-control" placeholder="Sak" name="tempe[]" step="0.01" min="0" required value="0">
																</h6>
															</td>
															<td>
																<h6 class="mb-1">
																	<input type="number" class="form-control" placeholder="Sak" name="datang[]" step="0.01" min="0" required value="0">
																</h6>
															</td>
														</tr>
														@endfor
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
