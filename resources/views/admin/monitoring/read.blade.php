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
                                        <h5 class="m-b-10">Monitoring</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="javascript:">Data Monitoring</a></li>
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
                                <div class="col-xl-12 col-md-12">
                                    <div class="card Recent-Users">
                                        <div class="card-header">
                                            <form action="{{ route('admin.monitoring') }}" method="GET">
                                                <div class="row">
                                                    <div class="col-xl-2 col-md-2">
                                                        <a href="{{ route('admin.create_monitoring') }}"
                                                            class="btn theme-bg"
                                                            style="color: white; width: 100%;">Tambah</a>
                                                    </div>
                                                    <div class="col-xl-2 col-md-2">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control datepicker"
                                                                placeholder="Tanggal Awal" name="from"
                                                                value="{{ request('from') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-2 col-md-2">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control datepicker"
                                                                placeholder="Tanggal Akhir" name="to"
                                                                value="{{ request('to') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-2 col-md-2">
                                                        <button type="submit" class="btn theme-bg"
                                                            style="color: white; width: 100%;">Lihat</button>
                                                    </div>

                                                    <div class="col-xl-2 col-md-2">
                                                        <a href="{{ route('admin.cetakmonitoring', ['from' => request('from'), 'to' => request('to')]) }}"
                                                            class="btn btn-danger" style="color: white; width: 100%;"
                                                            target="_blank">
                                                            <i class="feather icon-file-text"></i> Download PDF
                                                        </a>
                                                    </div>

                                                    <div class="col-xl-2 col-md-2">
                                                        <a href="javascript:void(0)" class="btn btn-warning"
                                                            id="btnLogMonitoring">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                                width="16" height="16" class="main-grid-item-icon"
                                                                fill="none" stroke="currentColor" stroke-linecap="round"
                                                                stroke-linejoin="round" stroke-width="2">
                                                                <ellipse cx="12" cy="5" rx="9"
                                                                    ry="3" />
                                                                <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3" />
                                                                <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5" />
                                                            </svg>
                                                            Logs Sync
                                                        </a>
                                                    </div>
                                                    @if ($message = Session::get('warning'))
                                                        <br>
                                                        <div class="alert alert-warning alert-block">
                                                            <button type="button" class="close"
                                                                data-dismiss="alert">×</button>
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @endif
                                                    @if ($message = Session::get('success'))
                                                        <br>
                                                        <div class="alert alert-success alert-block">
                                                            <button type="button" class="close"
                                                                data-dismiss="alert">×</button>
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                            </form>
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
                                                                <h6 class="mb-1"><b>Tanggal Laporan</b></h6>
                                                            </th>
                                                            <th>
                                                                <h6 class="mb-1"><b>Aksi</b></h6>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data as $index => $row)
                                                            <tr class="unread">
                                                                <td>
                                                                    <h6 class="mb-1">{{ $index + 1 }}</h6>
                                                                </td>
                                                                <td data-order="{{ \Carbon\Carbon::parse($row->tgl_laporan)->format('Y-m-d H:i:s') }}">
                                                                    <h6 class="mb-1">
                                                                        {{ \Carbon\Carbon::parse($row->tgl_laporan)->locale('id')->translatedFormat('d F Y') }}
                                                                    </h6>
                                                                </td>
                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button
                                                                            class="theme-bg btn btn-secondary dropdown-toggle"
                                                                            type="button" id="dropdownMenuButton"
                                                                            data-toggle="dropdown" aria-haspopup="true"
                                                                            aria-expanded="false">
                                                                            Aksi
                                                                        </button>
                                                                        <div class="dropdown-menu"
                                                                            aria-labelledby="dropdownMenuButton">
                                                                            <a class="dropdown-item"
                                                                                href="{{ route('admin.detail_monitoring', ['id_monitoring' => $row->id_monitoring, 'status' => 0]) }}">Detail</a>
                                                                            <a class="dropdown-item" href="#"
                                                                                onclick="del('{{ url('admin/delete_monitoring', $row->id_monitoring) }}')">Hapus</a>
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
    <!-- Modal -->
    <div class="modal fade" id="logMonitoringModal" tabindex="-1" aria-labelledby="logMonitoringLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logMonitoringLabel">Log Sinkronisasi Monitoring</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal Awal</th>
                                <th>Tanggal Akhir</th>
                                <th>Total Data</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="logMonitoringTable">
                            <tr>
                                <td colspan="4" class="text-center">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $("#btnLogMonitoring").click(function() {
                $("#logMonitoringModal").modal("show");

                $.ajax({
                    url: "{{ route('log.sync.monitoring') }}", // Pastikan route ini dibuat di backend
                    method: "GET",
                    success: function(data) {
                        let rows = "";

                        if (data.length === 0) {
                            rows =
                                `<tr><td colspan="4" class="text-center text-warning">Tidak ada data log tersedia</td></tr>`;
                        } else {
                            data.forEach(function(log) {
                                rows += `
                            <tr>
                                <td>${log.start_date}</td>
                                <td>${log.end_date}</td>
                                <td>${log.total_data}</td>
                                <td>${log.status}</td>
                            </tr>
                        `;
                            });
                        }

                        $("#logMonitoringTable").html(rows);
                    },
                    error: function() {
                        $("#logMonitoringTable").html(
                            '<tr><td colspan="4" class="text-center text-danger">Gagal memuat data</td></tr>'
                            );
                    }
                });
            });
        });
    </script>
@endsection
