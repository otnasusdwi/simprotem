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
                                    <h5 class="m-b-10">Sales</h5>
                                </div>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="javascript:">Data Sales</a></li>
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
                                                <a href="{{ route('admin.create_sales') }}" class="btn theme-bg" style="color: white; width: 100%;">Tambah</a>
                                            </div>
                                        </div>
                                        @if ($message = Session::get('warning'))
                                        <br>
                                        <div class="alert alert-warning alert-block">
                                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                            <strong>{{ $message }}</strong>
                                        </div>
                                        @endif
                                        @if ($message = Session::get('success'))
                                        <br>
                                        <div class="alert alert-success alert-block">
                                            <button type="button" class="close" data-dismiss="alert">×</button> 
                                            <strong>{{ $message }}</strong>
                                        </div>
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
                                                            <h6 class="mb-1"><b>Nama</b></h6>
                                                        </th>   
                                                        <th>
                                                            <h6 class="mb-1"><b>Tipe</b></h6>
                                                        </th> 
                                                        <th>
                                                            <h6 class="mb-1"><b>Piutang</b></h6>
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
                                                            <h6 class="mb-1">{{$row->tipe}}</h6>
                                                        </td> 
                                                        <td>
                                                            <h6 class="mb-1">Rp {{ number_format($row->piutang,0,',','.') }},-</h6>
                                                        </td>      
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="theme-bg btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Aksi
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item" href="{{ route('admin.edit_sales', $row->id) }}">Edit</a>
                                                                    <a class="dropdown-item" href="{{ route('admin.reset_password', $row->id) }}">Reset Password</a>
                                                                    <a class="dropdown-item" href="#" onclick="del('{{ url('admin/delete_user', $row->id) }}')">Hapus</a>
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
@endsection