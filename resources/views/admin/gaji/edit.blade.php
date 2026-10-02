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
									<li class="breadcrumb-item"><a href="javascript:">Edit Data Gaji</a></li>
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
								<form method="POST" action="{{ route('admin.update_gaji') }}">
									@csrf
									<div class="card Recent-Users">
										<div class="card-header">
											@if ($message = Session::get('warning'))
											<div class="alert alert-warning alert-block">
												<button type="button" class="close" data-dismiss="alert">×</button> 
												<strong>{{ $message }}</strong>
											</div>
											@endif
										</div>
										<div class="card-header">
											<h5>{{$bulan}}, {{$tahun}}</h5>
											<input type="hidden" name="bulan" value="{{$bulan}}">
											<input type="hidden" name="tahun" value="{{$tahun}}">
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
																<h6 class="mb-1"><b>NO</b></h6>
															</th> 
															<th>
																<h6 class="mb-1"><b>KARYAWAN</b></h6>
															</th> 
															<th>
																<h6 class="mb-1"><b>MASUK</b></h6>
															</th> 
															<th>
																<h6 class="mb-1"><b>GAJI</b></h6>
															</th>
															<th>
																<h6 class="mb-1"><b>HUTANG & BON</b></h6>
															</th>
															<th>
																<h6 class="mb-1"><b>JAGA MALAM</b></h6>
															</th>
														</tr> 
													</thead>
													<tbody> 
														@foreach($data[0] as $index => $row)
														<input type="hidden" name="id[0][]" value="{{$row->id}}">
														<tr>
															<td>
																<h6 class="mb-1">{{ $index+1 }}</h6>
															</td> 
															<td>
																<h6 class="mb-1">{{$row->name}}</h6>
															</td> 
															<td>
																<h6 class="mb-1">
																	<input type="number" value="{{$row->masuk}}" class="form-control" placeholder=""
																	name="masuk[0][]" min="0" required>
																</h6>
															</td>
															<td>
																<h6 class="mb-1">
																	<input type="number"  value="{{$row->gaji_karyawan}}" class="form-control" placeholder=""
																	name="gaji_karyawan[0][]" min="0" required>
																</h6>
															</td>
															<td>
																<h6 class="mb-1">
																	<input type="number" value="{{$row->hutang}}" class="form-control" placeholder=""
																	name="hutang[0][]" min="0" required>
																</h6>
															</td>
															<td>
																<h6 class="mb-1">
																	<input type="number" value="{{$row->jaga_malam}}"  class="form-control" placeholder=""
																	name="jaga_malam[0][]" min="0" required value="0">
																</h6>
															</td>
														</tr>
														@endforeach     
													</tbody>
												</table>
											</div>
										</div>
										<br>
										<div class="card-header">
											<h5>Tanggal 15</h5>
										</div>
										<div class="card-block px-0 py-3">
											<div class="table-responsive">
												<table class="table table-hover text-center" id="">
													<thead>
														<tr class="unread">   
															<th>
																<h6 class="mb-1"><b>NO</b></h6>
															</th> 
															<th>
																<h6 class="mb-1"><b>KARYAWAN</b></h6>
															</th> 
															<th>
																<h6 class="mb-1"><b>MASUK</b></h6>
															</th> 
															<th>
																<h6 class="mb-1"><b>GAJI</b></h6>
															</th>
															<th>
																<h6 class="mb-1"><b>HUTANG & BON</b></h6>
															</th>
															<th>
																<h6 class="mb-1"><b>JAGA MALAM</b></h6>
															</th>
														</tr> 
													</thead>
													<tbody> 
														@foreach($data[1] as $index => $row)
														<input type="hidden" name="id[1][]" value="{{$row->id}}">
														<tr>
															<td>
																<h6 class="mb-1">{{ $index+1 }}</h6>
															</td> 
															<td>
																<h6 class="mb-1">{{$row->name}}</h6>
															</td> 
															<td>
																<h6 class="mb-1">
																	<input type="number" value="{{$row->masuk}}" class="form-control" placeholder=""
																	name="masuk[1][]" min="0" required>
																</h6>
															</td>
															<td>
																<h6 class="mb-1">
																	<input type="number"  value="{{$row->gaji_karyawan}}" class="form-control" placeholder=""
																	name="gaji_karyawan[1][]" min="0" required>
																</h6>
															</td>
															<td>
																<h6 class="mb-1">
																	<input type="number" value="{{$row->hutang}}" class="form-control" placeholder=""
																	name="hutang[1][]" min="0" required>
																</h6>
															</td>
															<td>
																<h6 class="mb-1">
																	<input type="number" value="{{$row->jaga_malam}}"  class="form-control" placeholder=""
																	name="jaga_malam[1][]" min="0" required value="0">
																</h6>
															</td>
														</tr>
														@endforeach     
													</tbody>
												</table>
												<div class="text-center">
													<button type="submit" class="btn theme-bg"
													style="color: white; width: 250px;"><b>SUMBIT</b></button>
												</div>
												
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