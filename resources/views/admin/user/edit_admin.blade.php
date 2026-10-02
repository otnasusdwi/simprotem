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
									<h5 class="m-b-10">Admin</h5>
								</div>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
									<li class="breadcrumb-item"><a href="javascript:">Edit Admin</a></li>
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
							<div class="col-sm-12">
								<div class="card">
									<div class="card-body">
										@if ($message = Session::get('warning'))
										<div class="alert alert-warning alert-block">
											<button type="button" class="close" data-dismiss="alert">×</button> 
											<strong>{{ $message }}</strong>
										</div>
										@endif
										<form method="POST" action="{{ route('admin.update_admin') }}">
											@csrf
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Nama Admin</label>
														<input type="text" class="form-control" placeholder="Nama Admin" name="name" value="{{ $data->name }}" required>
														<input type="hidden" name="id" value="{{ $data->id }}">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>Level</label>
														<select class="form-control" id="exampleFormControlSelect1" name="level" required>
															<option value="1" @if ($data->level == 1) selected @endif>Admin</option>
															<option value="2" @if ($data->level == 2) selected @endif>Manager</option>
															<option value="3" @if ($data->level == 3) selected @endif>Owner</option>
														</select>
													</div>
												</div>
												<div class="col-md-12">
													<button type="submit" class="btn btn-primary">Submit</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
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