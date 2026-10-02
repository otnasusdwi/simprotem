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
									<li class="breadcrumb-item"><a href="javascript:">Input Data Kulit</a></li>
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
								<form method="POST" action="{{ route('admin.store_kulit') }}">
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
												<div class="col-xl-3 col-md-3">
													<div class="form-group">
														<input type="text" required class="form-control datepicker" placeholder="Tanggal Laporan" name="tgl" required="required">
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
																<h6 class="mb-1"><b>No</b></h6>
															</th> 
															<th>
																<h6 class="mb-1"><b>Nama</b></h6>
															</th> 
															<th>
																<h6 class="mb-1"><b>Kulit</b></h6>
															</th> 
															<th>
																<h6 class="mb-1"><b>Bayar</b></h6>
															</th> 
														</tr> 
													</thead>
													<tbody> 
														@foreach($data as $i => $row)
														<tr>
															<td>
																<h6 class="mb-1">
																	<b>{{$i+1}}</b>
																</h6>
															</td>
															<td>
																<h6 class="mb-1">
																	{{$row->name}}
																</h6>
															</td>
															<td>
																<h6 class="mb-1">
																	<input type="hidden" name="id_pelanggan[]" value="{{$row->id}}">
																	<input type="number" class="form-control" placeholder="Sak" name="kulit[]" min="0" required value="0">
																</h6>
															</td>
															<td>
																<h6 class="mb-1">
																	<input type="number" class="form-control" placeholder="" name="bayar[]" min="0" required value="0">
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