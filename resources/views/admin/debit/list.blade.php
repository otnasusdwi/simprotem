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
									<h5 class="m-b-10">Debit Kredit Harian</h5>
								</div>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
									<li class="breadcrumb-item"><a href="javascript:">Data Debit Kredit Harian</a></li>
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
											<form method="get" action="" class="col-xl-12 col-md-12">
												<div class="row">
													<div class="col-xl-2 col-md-2">
														<div class="form-group">
															<input type="text" required class="form-control datepicker" placeholder="Tanggal Laporan" name="tgl" required="required" value="{{$get->tgl}}">
														</div>
													</div>
													<div class="col-xl-2 col-md-2">
														<button type="submit" class="btn theme-bg" style="color: white; width: 100%;">Lihat</button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>

							<div class="col-xl-12 col-md-12">
								<div class="card Recent-Users">
									<div class="card-header">
										@if ($get->tgl)
										<h5>{{ Carbon\Carbon::parse($get->tgl)->translatedFormat('d F Y')}}</h5>
										@endif
									</div>
									@if (count($debit_sales) != 0)
									<div class="card-header">
										<div class="row">
											<div class="col-xl-2 col-md-2">
												<a href="{{ URL::to('admin/input_debit?tgl='.$get->tgl) }}" class="btn theme-bg" style="color: white; width: 100%;">Input</a>
											</div>
											@if (Auth::user()->level == 3)
											<div class="col-xl-3 col-md-3">
												<a href="{{ URL::to('admin/detail_debit?tgl='.$get->tgl) }}" class="btn theme-bg" style="color: white; width: 100%;">Debit Kredit Bulan {{ Carbon\Carbon::parse($get->tgl)->translatedFormat('F')}}</a>
											</div>
											@endif
										</div>
									</div>
									@endif

									<div class="card-block px-0 py-3">
										<div class="table-responsive">
											<table class="table table-hover text-center" id="">
												<thead>
													<tr class="unread">   
														<th>
															<h6 class="mb-1"><b>No</b></h6>
														</th> 
														<th>
															<h6 class="mb-1"><b>Keterangan</b></h6>
														</th>  
														<th>
															<h6 class="mb-1"><b>Tanggal Setor</b></h6>
														</th>                                            
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Debit</b></h6>
														</th>
														<th style="text-align: right;">
															<h6 class="mb-1"><b>Kredit</b></h6>
														</th>
														{{-- <th>
															<h6 class="mb-1"><b>Aksi</b></h6>
														</th>   --}}
													</tr>
												</thead>
												<tbody>                                                 
													@foreach($debit_sales as $index => $row)
													<tr class="unread">   
														<td>
															<h6 class="mb-1">{{ $index+1 }}</h6>
														</td> 
														<td>
															<h6 class="mb-1">{{$row->name}}</h6>
														</td>
														<td>
															<h6 class="mb-1">{{ Carbon\Carbon::parse($row->acc)->translatedFormat('d F Y') }}</h6>
														</td>   
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format($row->setoran,0,',','.') }},-</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format(0,0,',','.') }},-</h6>
														</td>
													</tr>
													@endforeach
													@foreach($debit_pengeluaran as $i => $row)
													<tr class="unread">  
														<td>
															<h6 class="mb-1">{{ count($debit_sales) + ($i+1) }}</h6>
														</td> 
														<td>
															<h6 class="mb-1">
																{{$row->name}}
																@if ($row->ket)
																<b>
																	<i>
																		( {{$row->ket}} )
																	</i>
																</b>
																@endif
															</h6>
														</td>
														<td>
															<h6 class="mb-1">{{ Carbon\Carbon::parse($row->tgl_setor)->translatedFormat('d F Y') }}</h6>
														</td>   
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format($row->debit,0,',','.') }},-</h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1">Rp {{ number_format($row->kredit,0,',','.') }},-</h6>
														</td>  
														<td>
															<td>
																<div class="dropdown">
																	<button class="theme-bg btn btn-secondary dropdown-toggle"
																	type="button" id="dropdownMenuButton"
																	data-toggle="dropdown" aria-haspopup="true"
																	aria-expanded="false">
																Aksi </button>
																<div class="dropdown-menu"
																aria-labelledby="dropdownMenuButton">
																<a class="dropdown-item"
																href="{{ route('admin.edit_debit', $row->id) }}">Edit</a>
																<a class="dropdown-item" href="#"
																onclick="del('{{ url('admin/delete_debit', $row->id) }}')">Hapus</a>

															</div>
														</td> 
													</tr>
													@endforeach
													<tr class="unread">   
														<td colspan="3">
															<h6 class="mb-1"><b>Total</b></h6>
														</td>  
														<td style="text-align: right;">
															<h6 class="mb-1"><b>Rp {{ number_format($jml_debit_sales + $jml_debit_pengeluaran,0,',','.') }},-</b></h6>
														</td>
														<td style="text-align: right;">
															<h6 class="mb-1"><b>Rp {{ number_format($jml_kredit_sales + $jml_kredit_pengeluaran,0,',','.') }},-</b></h6>
														</td>
														{{-- <td style="text-align: right;"> </td>   --}}
													</tr>
													<tr class="unread">   
														<td colspan="4">
															<h6 class="mb-1"><b>Saldo</b></h6>
														</td>  
														<td style="text-align: right;">
															<h6 class="mb-1"><b>Rp {{ number_format(($jml_debit_sales + $jml_debit_pengeluaran)-($jml_kredit_sales + $jml_kredit_pengeluaran),0,',','.') }},-</b></h6>
														</td>
														{{-- <td style="text-align: right;"> </td>   --}}
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
@endsection