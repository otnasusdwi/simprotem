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
											@if ($errors->any())
											<div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
											@endif
											@if (session('success'))
											<div class="alert alert-success" role="alert">{{ session('success') }}</div>
											@endif
											<form method="get" action="{{ route('admin.home') }}">
												<div class="row">
													<div class="col-xl-2 col-md-2">
														<div class="form-group">
															<label for="id_tipe">Tipe</label>
															<div class="filter-select-wrap">
															<select class="form-control" name="id_tipe" id="id_tipe" aria-describedby="tipe-loading">
																<option value="">Semua Tipe</option>
															@foreach($tipe as $row)
															<option value="{{ $row->id_tipe }}"  @if($row->id_tipe==$get->id_tipe) selected @endif>{{ $row->tipe }}</option>
															@endforeach
															</select>
															<span class="filter-select-loader" id="tipe-loading" role="status" aria-live="polite"><span class="filter-select-spinner"></span><span class="sr-only">Memuat pilihan tipe</span></span>
															</div>
													</div>
												</div>
													<div class="col-xl-2 col-md-2">
														<div class="form-group">
															<label for="id_user">Sales</label>
															<div class="filter-select-wrap">
															<select class="form-control" name="id_user" id="id_user" aria-describedby="sales-loading">
																<option value="">Semua Sales</option>
																@foreach($sales as $row)
																<option value="{{ $row->id }}" data-tipe="{{ $row->tipe }}" @if($row->id==$get->id_user) selected @endif>{{ $row->name }}</option>
															@endforeach
															</select>
															<span class="filter-select-loader" id="sales-loading" role="status" aria-live="polite"><span class="filter-select-spinner"></span><span class="sr-only">Memuat pilihan sales</span></span>
															</div>
													</div>
												</div>
													<div class="col-xl-2 col-md-2">
														<div class="form-group">
															<label for="from">Tanggal Awal</label>
															<input id="from" type="text" class="form-control datepicker" placeholder="Tanggal Awal" name="from" value="{{$get->from}}" autocomplete="off" required>
													</div>
												</div>
													<div class="col-xl-2 col-md-2">
														<div class="form-group">
															<label for="to">Tanggal Akhir</label>
															<input id="to" type="text" class="form-control datepicker" placeholder="Tanggal Akhir" name="to" value="{{$get->to}}" autocomplete="off" required>
														</div>
													</div>
													<div class="col-xl-4 col-md-4 d-flex align-items-end">
														<div class="form-group d-flex w-100" style="gap: 8px;">
															<button type="submit" class="btn theme-bg flex-fill text-white"><i class="feather icon-search"></i> Lihat</button>
															<a href="{{ route('admin.home') }}" class="btn btn-simprotem-outline flex-fill"><i class="feather icon-rotate-ccw"></i> Reset</a>
														</div>
													</div>
												</div>
											</form>
											<hr>
											<div class="d-flex flex-wrap justify-content-between align-items-center mb-3" style="gap: 12px;">
												<p class="mb-0 text-muted">Menampilkan <strong>{{ count($data) }}</strong> laporan periode {{ date('d-m-Y', strtotime($get->from)) }} sampai {{ date('d-m-Y', strtotime($get->to)) }}.</p>
												<div class="d-flex" style="gap: 8px;">
													@if ($get->id_tipe)
													<a target="_blank" class="btn btn-success" href="{{ route('admin.cetak', ['id_user' => $get->id_user ?: 'NULL', 'id_tipe' => $get->id_tipe, 'from' => $get->from, 'to' => $get->to]) }}"><i class="feather icon-download"></i> Excel</a>
													@endif
													<a target="_blank" class="btn btn-warning" href="{{ route('admin.cetakpdf', ['id_user' => $get->id_user, 'id_tipe' => $get->id_tipe, 'from' => $get->from, 'to' => $get->to]) }}"><i class="feather icon-file-text"></i> PDF</a>
												</div>
											</div>
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
																		<h6 class="mb-1">{{ $row->nama_tipe ?: '-' }}</h6>
														</td>                                                   
														<td>
															<h6 class="mb-1">{{ date('d-m-Y', strtotime($row->tgl_laporan)) }}</h6>
														</td>
														<td>
															<h6 class="mb-1">{{ date('H:i:s', strtotime($row->tgl_laporan)) }}</h6>
														</td>
														<td>
																		@if ($row->status == 0)
																		<span class="badge badge-warning px-3 py-2">Belum Dibayar</span>
																		@else
																		<span class="badge badge-success px-3 py-2">Sudah Dibayar</span>
																		<small class="d-block text-muted mt-1">{{ $row->acc ? date('d-m-Y H:i:s', strtotime($row->acc)) : '-' }}</small>
																		@endif
														</td> 
														<td>
															<div class="dropdown">
																<button class="theme-bg btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																	Aksi
																</button>
																<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
																	@if (Auth::user()->level != 1)
																	@if ($row->status == 0)
																								<a class="dropdown-item" href="#" onclick="confirmReportStatus('{{ route('admin.status', $row->id_laporan) }}'); return false;"><i class="feather icon-check-circle mr-2"></i>Ubah Status</a>
																	@endif
																	@endif
																							<a class="dropdown-item" href="{{ route('admin.detail', $row->id_laporan) }}"><i class="feather icon-eye mr-2"></i>Detail</a>
																							<div class="dropdown-divider"></div>
																							<a target="_blank" class="dropdown-item" href="{{ route('admin.pdf', ['id_laporan' => $row->id_laporan]) }}"><i class="feather icon-printer mr-2"></i>Print</a>
																							<a target="_blank" class="dropdown-item" href="{{ route('admin.pdf-kasir', ['id_laporan' => $row->id_laporan]) }}"><i class="feather icon-file-text mr-2"></i>Print Kasir</a>
																							@if (Auth::user()->level != 1)
																							<div class="dropdown-divider"></div>
																							<a class="dropdown-item" href="{{ route('admin.edit', $row->id_laporan) }}"><i class="feather icon-edit-2 mr-2"></i>Edit</a>
																							<a class="dropdown-item text-danger" href="#" onclick="confirmReportDelete('{{ route('admin.hapus', $row->id_laporan) }}'); return false;"><i class="feather icon-trash-2 mr-2"></i>Hapus</a>
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
							<form id="report-delete-form" method="POST" action="" class="d-inline">
								@csrf
								@method('DELETE')
								<button type="submit" class="btn btn-danger">Hapus</button>
							</form>
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
							<form id="report-status-form" method="POST" action="" class="d-inline">
								@csrf
								@method('PATCH')
								<button type="submit" class="btn btn-primary">Ubah Status</button>
							</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script>
		$(document).ready(function () {
			var selectedSales = @json((string) ($get->id_user ?? ''));
			var salesOptions = @json($salesOptions);

			function refreshSalesOptions() {
				var selectedType = String($('#id_tipe').val() || '');
				var $sales = $('#id_user');
				$sales.empty().append($('<option>', { value: '', text: 'Semua Sales' }));

				$.each(salesOptions, function (_, sales) {
					if (!selectedType || sales.tipe === selectedType) {
						$sales.append($('<option>', {
							value: sales.id,
							text: sales.name,
							selected: sales.id === selectedSales
						}));
					}
				});

				if (!$sales.find('option:selected').length) {
					$sales.val('');
				}
			}

			function withSelectLoader($select, callback) {
				var $wrapper = $select.closest('.filter-select-wrap');
				$wrapper.addClass('is-loading');
				$select.attr('aria-busy', 'true');

				window.setTimeout(function () {
					callback();
					$select.removeAttr('aria-busy');
					$wrapper.removeClass('is-loading');
				}, 220);
			}

			refreshSalesOptions();
			$('#id_tipe').on('change', function () {
				selectedSales = '';
				withSelectLoader($('#id_tipe, #id_user'), refreshSalesOptions);
			});
			$('#id_user').on('change', function () {
				withSelectLoader($(this), function () {});
			});
		});

	function confirmReportDelete(url) {
		$('#report-delete-form').attr('action', url);
		$('#delete').modal('show');
	}

	function confirmReportStatus(url) {
		$('#report-status-form').attr('action', url);
		$('#status').modal('show');
	}
</script>
@endsection
