@extends('../layouts.app')
@section('content')
<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
	<div class="pcoded-wrapper">
		<div class="pcoded-content">
			<div class="pcoded-inner-content">
				<!-- [ breadcrumb ] start -->

				<!-- [ breadcrumb ] end -->
				<div class="main-body">
					<div class="page-wrapper">
						<!-- [ Main Content ] start -->
						<div class="row">
							<!--[ Recent Users ] start-->
							<div class="col-xl-12 col-md-12">
								<div class="card Recent-Users">
									<div class="card-header">
										<h5>Laporan</h5>
									</div>
									<div class="card-block px-0 py-3">
										<div class="table-responsive">
											<table class="table table-hover">
												<tbody>
													<tr class="unread">
														<td><img class="rounded-circle" style="width:40px;" src="{{ asset('images/user/avatar-1.jpg') }}" alt="activity-user"></td>
														<td>
															<h6 class="mb-1">Isabella Christensen</h6>
															<p class="m-0">Lorem Ipsum is simply…</p>
														</td>
														<td>
															<h6 class="text-muted"><i class="fas fa-circle text-c-green f-10 m-r-15"></i>11 MAY 12:56</h6>
														</td>
														<td><a href="#!" class="label theme-bg2 text-white f-12">Reject</a><a href="#!" class="label theme-bg text-white f-12">Approve</a></td>
													</tr>
													<tr class="unread">
														<td><img class="rounded-circle" style="width:40px;" src="{{ asset('images/user/avatar-2.jpg') }}" alt="activity-user"></td>
														<td>
															<h6 class="mb-1">Mathilde Andersen</h6>
															<p class="m-0">Lorem Ipsum is simply text of…</p>
														</td>
														<td>
															<h6 class="text-muted"><i class="fas fa-circle text-c-red f-10 m-r-15"></i>11 MAY 10:35</h6>
														</td>
														<td><a href="#!" class="label theme-bg2 text-white f-12">Reject</a><a href="#!" class="label theme-bg text-white f-12">Approve</a></td>
													</tr>
													<tr class="unread">
														<td><img class="rounded-circle" style="width:40px;" src="{{ asset('images/user/avatar-3.jpg') }}" alt="activity-user"></td>
														<td>
															<h6 class="mb-1">Karla Sorensen</h6>
															<p class="m-0">Lorem Ipsum is simply…</p>
														</td>
														<td>
															<h6 class="text-muted"><i class="fas fa-circle text-c-green f-10 m-r-15"></i>9 MAY 17:38</h6>
														</td>
														<td><a href="#!" class="label theme-bg2 text-white f-12">Reject</a><a href="#!" class="label theme-bg text-white f-12">Approve</a></td>
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
<!-- [ Main Content ] end -->
@endsection