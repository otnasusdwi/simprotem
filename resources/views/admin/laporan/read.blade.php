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
									<li class="breadcrumb-item"><a href="javascript:">Data Laporan</a></li>
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
										<form method="get" action="">
											<div class="row">
												<input type="hidden" name="filter" value="{{$get->filter}}">
												<div class="col-xl-2 col-md-2">
													<div class="form-group">
														<select class="form-control" id="exampleFormControlSelect1" name="id_tipe" id="id_tipe">
															{{-- <option selected disabled>- Pilih Tipe -</option> --}}
															<option value="">Semua Tipe</option>
															@foreach($tipe as $row)
															<option value="{{ $row->id_tipe }}"  @if($row->id_tipe==$get->id_tipe) selected @endif>{{ $row->tipe }}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="col-xl-2 col-md-2">
													<div class="form-group">
														<select class="form-control" id="exampleFormControlSelect1" name="id_user">
															<option value="">Semua Sales</option>
															@foreach($sales as $row)
															<option value="{{ $row->id }}"  @if($row->id==$get->id_user) selected @endif>{{ $row->name }}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="col-xl-2 col-md-2">
													<div class="form-group">
														<input type="text" required class="form-control datepicker" placeholder="Tanggal Awal" name="from" required="required" value="{{$get->from}}">
													</div>
												</div>
												<div class="col-xl-2 col-md-2">
													<div class="form-group">
														<input type="text" required class="form-control datepicker" placeholder="Tanggal Akhir" name="to" required="required" value="{{$get->to}}">
													</div>
												</div>
												
												<div class="col-xl-2 col-md-2">
													<button type="submit" class="btn theme-bg" style="color: white; width: 100%;">Lihat</button>
												</div>

												<div class="col-xl-2 col-md-2">
													<a href="{{ route('admin.cetakpdf', ['id_user' => $get->id_user, 'id_tipe' => $get->id_tipe, 'from' => $get->from, 'to' => $get->to]) }}" class="btn btn-danger" style="color: white; width: 100%;" target="_blank">
														<i class="feather icon-file-text"></i> Download PDF
													</a>
												</div>
												
												@if ($get->id_tipe)
												<div class="col-xl-2 col-md-2">
													<div class="dropdown">
														<button class="theme-bg btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Cetak
														</button>
														<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
															<a target="_blank" class="dropdown-item" href="{{ route('admin.cetak') }}?id_user={{isset($get->id_user) ? $get->id_user : 'NULL'}}&id_tipe={{isset($get->id_tipe) ? $get->id_tipe : 'NULL'}}&from={{$get->from}}&to={{$get->to}}">Export Excel</a>
															<a target="_blank" class="dropdown-item" href="{{ route('admin.cetakpdf') }}?id_user={{isset($get->id_user) ? $get->id_user : 'NULL'}}&id_tipe={{isset($get->id_tipe) ? $get->id_tipe : 'NULL'}}&from={{$get->from}}&to={{$get->to}}">Cetak PDF</a>
														</div>
													</div>
												</div>
												@endif
											</div>
										</form>
										<hr>
										@if ($get->id_tipe && $get->id_user)
										@if ($setoran != 0)
										<div class="row">
											<div class="col-md-8">
												<h5><b>TOTAL SETORAN :</b> Rp {{ number_format($setoran,0,',','.') }},- | <b>RATA-RATA :</b> Rp {{ number_format($setoran/count($data),0,',','.') }},- <br><br> <b>SUBSIDI :</b> Rp {{ number_format(5000*count($data),0,',','.') }},-</h5>
											</div>
											
											<div class="col-md-2">
												<a class="btn theme-bg" style="color: white; width: 100%;" href="{{ route('admin.detail_setoran') }}?id_user={{isset($get->id_user) ? $get->id_user : 'NULL'}}&id_tipe={{isset($get->id_tipe) ? $get->id_tipe : 'NULL'}}&from={{$get->from}}&to={{$get->to}}">Detail Setoran</a>
												{{-- <button type="submit" class="btn theme-bg" style="color: white; width: 100%;">Detail Setoran</button> --}}
											</div>
										</div>
											 
										@endif
										@endif
									</div>
									<div class="card-block px-0 py-3">
										<div class="table-responsive">
											<table class="table table-hover text-center" id="table_id">
												<thead>
													<tr class="unread">   
														<th>
															<h6 class="mb-1"><b>No</b></h6>
														</th> 
														<th>
															<h6 class="mb-1"><b>Nama Sales</b></h6>
														</th> 
														<th>
															<h6 class="mb-1"><b>Tipe</b></h6>
														</th>                                                 
														<th>
															<h6 class="mb-1"><b>Tanggal Laporan</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Jam Laporan</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Status</b></h6>
														</th>
														<th>
															<h6 class="mb-1"><b>Aksi</b></h6>
														</th>
													</tr>
												</thead>
												<tbody>                                                 
													@foreach($data as $index => $row)
													<tr class="unread">   
														<td>
															<h6 class="mb-1">{{ $index+1 }}</h6>
														</td> 
														<td>
															<h6 class="mb-1">{{$row->name}}</h6>
														</td>  
														<td>
															<h6 class="mb-1">
																@foreach($tipe as $tp)
																@if ($tp->id_tipe == $row->id_tipe)
																{{ $tp->tipe }}
																@endif
																@endforeach
															</h6>
														</td>                                                   
														<td>
															<h6 class="mb-1">{{ date('d-m-Y', strtotime($row->tgl_laporan)) }}</h6>
														</td>
														<td>
															<h6 class="mb-1">{{ date('H:i:s', strtotime($row->tgl_laporan)) }}</h6>
														</td>
														<td>
															<h6 class="mb-1">
																@if ( $row->status == 0 )
																<h6><strong style="color: red;">Belum Dibayar</strong></h6>
																@else
																<h6><strong style="color: green;">Sudah Dibayar</strong></h6>
																<h6>{{ date('d-m-Y H:i:s', strtotime($row->acc)) }}</h6>
																@endif
															</h6>
														</td> 
														<td>
															<div class="dropdown">
																<button class="theme-bg btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	Aksi
																</button>
																<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
																	@if (Auth::user()->level != 1)
																	@if ($row->status == 0)
																	<a class="dropdown-item" href="#" onclick="stat('{{ url('admin/status', $row->id_laporan) }}')">Ubah Status</a>
																	@endif
																	@endif
																	<a class="dropdown-item" href="{{ route('admin.detail', $row->id_laporan) }}">Detail</a>
																	<a target="_blank" class="dropdown-item" href="{{ route('admin.pdf') }}?id_laporan={{ $row->id_laporan}}">Print</a>
																	<a target="_blank" class="dropdown-item" href="{{ route('admin.pdf-kasir') }}?id_laporan={{ $row->id_laporan}}">Print Kasir</a>
																	@if (Auth::user()->level != 1)
																	<a class="dropdown-item" href="{{ route('admin.edit', $row->id_laporan) }}">Edit</a>
																	<a class="dropdown-item" href="#" onclick="del('{{ url('admin/hapus', $row->id_laporan) }}')">Hapus</a>
																	@endif
																</div>
															</div>
														</td>
													</tr>
													@endforeach
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

<!-- [ Main Content ] end -->
<div id="delete" tabindex="-1" role="dialog" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="text-center">
					<div class="text-danger"><span class="modal-main-icon mdi mdi-close-circle-o"></span></div>
					<h3>Perhatian!</h3>
					<p>Anda yakin akan menghapus data?</p>
				</div>
			</div>
			<div class="modal-footer">
				<div class="text-center">
					<div class="xs-mt-50">
						<button type="button" data-dismiss="modal" class="btn btn-space btn-default">Batal</button>
						<i id="del"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="status" tabindex="-1" role="dialog" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="text-center">
					<div class="text-danger"><span class="modal-main-icon mdi mdi-close-circle-o"></span></div>
					<h3>Perhatian!</h3>
					<p>Anda yakin akan mengubah status pembayaran?</p>
				</div>
			</div>
			<div class="modal-footer">
				<div class="text-center">
					<div class="xs-mt-50">
						<button type="button" data-dismiss="modal" class="btn btn-space btn-default">Batal</button>
						<i id="stat"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
{{-- @section('script')
<script>
	$(document).ready(function () {
		$('#id_tipe').on('change', function () {
			var id_tipe = $(this).val();
			if (id_tipe) {
				$.ajax({
					url: '/getsales/' + id_tipe,
					type: "GET",
					data: {
						"_token": "{{ csrf_token() }}"
					},
					dataType: "json",
					success: function (data) {
						if (data) {
							console.log(data);
							$('#id_user').empty();
							$('#id_user').append('<option value="0">Semua Sales</option>');
							$.each(data, function (key, id_user) {
								console.log(id_user);
								$('select[name="id_user"]').append('<option value="' + id_user + '">' +
									id_user + '</option>');
							});
						} else {
							$('#id_user').empty();
						}
					}
				});
			} else {
				$('#id_user').empty();
			}
		});
	});
</script>
@endsection --}}