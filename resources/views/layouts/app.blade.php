<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tempe Super Dangsul</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('images/favicon-simprotem.png') }}" type="image/png">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome/css/fontawesome-all.min.css') }}">
    <!-- animation css -->
    <link rel="stylesheet" href="{{ asset('plugins/animation/css/animate.min.css') }}">
    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/datatables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.standalone.min.css">

</head>

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar">
        <div class="navbar-wrapper">
            <div class="navbar-brand header-logo">
                <a href="{{ Auth::user()->level == 1 ? route('admin.monitoring') : route('admin.home') }}" class="b-brand sidebar-brand">
                    <img src="{{ asset('images/simprotem-white.png') }}" alt="Simprotem" class="sidebar-logo-full">
                    <img src="{{ asset('images/favicon-simprotem.png') }}" alt="Simprotem" class="sidebar-logo-thumb logo-thumb">
                </a>
                <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a>
            </div>
            <div class="navbar-content scroll-div">
                <ul class="nav pcoded-inner-navbar">
                    <li class="nav-item pcoded-menu-caption">
                        <label>Menu</label>
                    </li>

                    @php
                        $segment = Request::segment(2);
                        $operasionalActive = in_array($segment, ['home', 'detail', 'detail_setoran', 'edit', 'monitoring', 'create_monitoring', 'detail_monitoring', 'edit_monitoring', 'transaksi'], true);
                        $keuanganActive = in_array($segment, ['pengeluaran', 'create_pengeluaran', 'edit_pengeluaran', 'debit', 'input_debit', 'detail_debit', 'edit_debit', 'setor_bank', 'input_setor_bank', 'detail_setor_bank', 'edit_setor_bank', 'gaji', 'create_gaji', 'input_gaji', 'edit_gaji'], true);
                        $persediaanActive = in_array($segment, ['kulit', 'input_kulit', 'detail_kulit', 'edit_kulit', 'kedelai', 'input_kedelai', 'edit_kedelai'], true);
                        $masterDataActive = in_array($segment, ['pelanggan', 'create_pelanggan', 'edit_pelanggan', 'karyawan', 'create_karyawan', 'edit_karyawan', 'tipe', 'create_tipe', 'edit_tipe', 'sales', 'create_sales', 'edit_sales', 'admin', 'create_admin', 'edit_admin', 'setting', 'create_harga', 'edit_harga'], true);
                    @endphp

                    @if (Auth::user()->level == 1)
                        <li class="nav-item pcoded-hasmenu active pcoded-trigger">
                            <a href="javascript:" class="nav-link">
                                <span class="pcoded-micon"><i class="feather icon-activity"></i></span>
                                <span class="pcoded-mtext">Operasional</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="{{ in_array($segment, ['monitoring', 'create_monitoring', 'detail_monitoring', 'edit_monitoring'], true) ? 'active' : '' }}">
                                    <a href="{{ route('admin.monitoring') }}">Monitoring</a>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item pcoded-hasmenu {{ $operasionalActive ? 'active pcoded-trigger' : '' }}">
                            <a href="javascript:" class="nav-link">
                                <span class="pcoded-micon"><i class="feather icon-activity"></i></span>
                                <span class="pcoded-mtext">Operasional</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="{{ in_array($segment, ['home', 'detail', 'detail_setoran', 'edit'], true) ? 'active' : '' }}">
                                    <a href="{{ route('admin.home') }}">Laporan</a>
                                </li>
                                <li class="{{ in_array($segment, ['monitoring', 'create_monitoring', 'detail_monitoring', 'edit_monitoring'], true) ? 'active' : '' }}">
                                    <a href="{{ route('admin.monitoring') }}">Monitoring</a>
                                </li>
                                <li class="{{ $segment === 'transaksi' ? 'active' : '' }}">
                                    <a href="{{ route('admin.transaksi') }}">Transaksi</a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item pcoded-hasmenu {{ $keuanganActive ? 'active pcoded-trigger' : '' }}">
                            <a href="javascript:" class="nav-link">
                                <span class="pcoded-micon"><i class="feather icon-credit-card"></i></span>
                                <span class="pcoded-mtext">Keuangan</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="{{ in_array($segment, ['pengeluaran', 'create_pengeluaran', 'edit_pengeluaran'], true) ? 'active' : '' }}"><a href="{{ route('admin.pengeluaran') }}">Data Pengeluaran</a></li>
                                <li class="{{ in_array($segment, ['debit', 'input_debit', 'detail_debit', 'edit_debit'], true) ? 'active' : '' }}"><a href="{{ route('admin.debit') }}">Debit Kredit Harian</a></li>
                                @if (Auth::user()->level == 3)
                                    <li class="{{ in_array($segment, ['setor_bank', 'input_setor_bank', 'detail_setor_bank', 'edit_setor_bank'], true) ? 'active' : '' }}"><a href="{{ route('admin.setor_bank') }}">Uang Setor Bank</a></li>
                                @endif
                                <li class="{{ in_array($segment, ['gaji', 'create_gaji', 'input_gaji', 'edit_gaji'], true) ? 'active' : '' }}"><a href="{{ route('admin.gaji') }}">Gaji</a></li>
                            </ul>
                        </li>

                        <li class="nav-item pcoded-hasmenu {{ $persediaanActive ? 'active pcoded-trigger' : '' }}">
                            <a href="javascript:" class="nav-link">
                                <span class="pcoded-micon"><i class="feather icon-box"></i></span>
                                <span class="pcoded-mtext">Persediaan</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="{{ in_array($segment, ['kulit', 'input_kulit', 'detail_kulit', 'edit_kulit'], true) ? 'active' : '' }}"><a href="{{ route('admin.kulit') }}">Stok Kulit</a></li>
                                <li class="{{ in_array($segment, ['kedelai', 'input_kedelai', 'edit_kedelai'], true) ? 'active' : '' }}"><a href="{{ route('admin.kedelai') }}">Stok Kedelai</a></li>
                            </ul>
                        </li>

                        <li class="nav-item pcoded-hasmenu {{ $masterDataActive ? 'active pcoded-trigger' : '' }}">
                            <a href="javascript:" class="nav-link">
                                <span class="pcoded-micon"><i class="feather icon-grid"></i></span>
                                <span class="pcoded-mtext">Master Data</span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="{{ in_array($segment, ['pelanggan', 'create_pelanggan', 'edit_pelanggan'], true) ? 'active' : '' }}"><a href="{{ route('admin.pelanggan') }}">Data Pelanggan Kulit</a></li>
                                <li class="{{ in_array($segment, ['karyawan', 'create_karyawan', 'edit_karyawan'], true) ? 'active' : '' }}"><a href="{{ route('admin.karyawan') }}">Data Karyawan</a></li>
                                <li class="{{ in_array($segment, ['tipe', 'create_tipe', 'edit_tipe'], true) ? 'active' : '' }}"><a href="{{ route('admin.tipe') }}">Tipe Sales</a></li>
                                <li class="{{ in_array($segment, ['sales', 'create_sales', 'edit_sales'], true) ? 'active' : '' }}"><a href="{{ route('admin.sales') }}">Data Sales</a></li>
                                <li class="{{ in_array($segment, ['admin', 'create_admin', 'edit_admin'], true) ? 'active' : '' }}"><a href="{{ route('admin.admin') }}">Data Admin</a></li>
                                <li class="{{ in_array($segment, ['setting', 'create_harga', 'edit_harga'], true) ? 'active' : '' }}"><a href="{{ route('admin.setting') }}">Setting Harga</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ navigation menu ] end -->

    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand-lg navbar-light">
        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse1" href="javascript:"><span></span></a>
            <a href="{{ Auth::user()->level == 1 ? route('admin.monitoring') : route('admin.home') }}" class="b-brand mobile-brand">
                <img src="{{ asset('images/simprotem.png') }}" alt="Simprotem">
            </a>
        </div>
        <a class="mobile-menu" id="mobile-header" href="javascript:">
            <i class="feather icon-more-horizontal"></i>
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li><a href="javascript:" class="full-screen" onclick="javascript:toggleFullScreen()"><i
                            class="feather icon-maximize"></i></a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li>
                    <div class="dropdown drp-user">
                        <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon feather icon-settings"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-notification">
                            <div class="pro-head">
                                <img src="{{ asset('images/simprotem.png') }}">
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                            <ul class="pro-body">
                                <li><a href="{{ route('logout') }}" class="dropdown-item"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                            class="feather icon-lock"></i> Logout</a></li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </header>
    <!-- [ Header ] end -->

    @yield('content')

    <!-- Required Js -->
    <script src="{{ asset('js/vendor-all.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/pcoded.min.js') }}"></script>

    <script type="text/javascript" charset="utf8" src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('js/simprotem-datepicker.js') }}"></script>

    @yield('script')

    <script>
        $(document).ready(function() {
            $('#table_id').DataTable({
                language: {
                    emptyTable: 'Tidak ada data pada periode atau filter yang dipilih',
                    info: 'Menampilkan _START_–_END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data yang ditampilkan',
                    infoFiltered: '(disaring dari _MAX_ data)',
                    lengthMenu: 'Tampilkan _MENU_ data',
                    loadingRecords: 'Memuat data…',
                    processing: 'Memproses data…',
                    search: 'Cari:',
                    zeroRecords: 'Data yang dicari tidak ditemukan',
                    paginate: {
                        first: 'Pertama',
                        last: 'Terakhir',
                        next: 'Berikutnya',
                        previous: 'Sebelumnya'
                    }
                },
                columnDefs: [
                    { orderable: false, targets: -1 }
                ]
            });
        });
    </script>

    <script type="text/javascript">
        function del(url) {
            $('#delete').modal();
            $('#del').html('<a class="btn btn-danger" href="' + url + '">Hapus</a>');
        }

        function stat(url) {
            $('#status').modal();
            $('#stat').html('<a class="btn btn-primary" href="' + url + '">Ubah Status</a>');
        }
    </script>

    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
        });
    </script>
</body>

</html>
