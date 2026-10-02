<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tempe Super Dangsul</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
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
                <a href="#" class="b-brand">
                    {{-- <div class="b-bg">
                        <i class="feather icon-trending-up"></i>
                    </div> --}}
                    <span class="b-title">Tempe Super Dangsul</span>
                </a>
                <a class="mobile-menu" id="mobile-collapse" href="javascript:"><span></span></a>
            </div>
            <div class="navbar-content scroll-div">
                <ul class="nav pcoded-inner-navbar">
                    <li class="nav-item pcoded-menu-caption">
                        <label>Menu</label>
                    </li>

                    @if (Auth::user()->level == 1)
                        <li
                            class="nav-item {{ Request::segment(2) === 'monitoring' || Request::segment(2) === 'create_monitoring' || Request::segment(2) === 'detail_monitoring' || Request::segment(2) === 'edit_monitoring' ? 'active' : '' }}">
                            <a href="{{ route('admin.monitoring') }}" class="nav-link "><span class="pcoded-micon"><i
                                        class="feather icon-bar-chart-2"></i></span><span
                                    class="pcoded-mtext">Monitoring</span></a>
                        </li>
                    @else
                        <li
                            class="nav-item {{ Request::segment(2) === 'home' || Request::segment(2) === 'detail' || Request::segment(2) === 'detail_setoran' || Request::segment(2) === 'edit' ? 'active' : '' }}">
                            <a href="{{ route('admin.home') }}" class="nav-link "><span class="pcoded-micon"><i
                                        class="feather icon-file-text"></i></span><span
                                    class="pcoded-mtext">Laporan</span></a>
                        </li>

                        <li
                            class="nav-item {{ Request::segment(2) === 'monitoring' || Request::segment(2) === 'create_monitoring' || Request::segment(2) === 'detail_monitoring' || Request::segment(2) === 'edit_monitoring' ? 'active' : '' }}">
                            <a href="{{ route('admin.monitoring') }}" class="nav-link "><span class="pcoded-micon"><i
                                        class="feather icon-bar-chart-2"></i></span><span
                                    class="pcoded-mtext">Monitoring</span></a>
                        </li>

                        <li class="nav-item {{ Request::segment(2) === 'transaksi' ? 'active' : '' }}">
                            <a href="{{ route('admin.transaksi') }}" class="nav-link "><span class="pcoded-micon"><i
                                        class="feather icon-credit-card"></i></span><span
                                    class="pcoded-mtext">Transaksi</span></a>
                        </li>

                        <li
                            class="nav-item {{ Request::segment(2) === 'pengeluaran' || Request::segment(2) === 'create_pengeluaran' || Request::segment(2) === 'edit_pengeluaran' ? 'active' : '' }}">
                            <a href="{{ route('admin.pengeluaran') }}" class="nav-link "><span class="pcoded-micon"><i
                                        class="feather icon-user"></i></span><span class="pcoded-mtext">Data
                                    Pengeluaran</span></a>
                        </li>

                        <li
                            class="nav-item {{ Request::segment(2) === 'debit' || Request::segment(2) === 'input_debit' || Request::segment(2) === 'detail_debit' || Request::segment(2) === 'edit_debit' ? 'active' : '' }}">
                            <a href="{{ route('admin.debit') }}" class="nav-link "><span class="pcoded-micon"><i
                                        class="feather icon-book"></i></span><span class="pcoded-mtext">Debit Kredit
                                    Harian</span></a>
                        </li>

                        @if (Auth::user()->level == 3)
                        <li
                            class="nav-item {{ Request::segment(2) === 'setor_bank' || Request::segment(2) === 'input_setor_bank' || Request::segment(2) === 'detail_setor_bank' || Request::segment(2) === 'edit_setor_bank' ? 'active' : '' }}">
                            <a href="{{ route('admin.setor_bank') }}" class="nav-link "><span class="pcoded-micon"><i class="feather icon-credit-card"></i></span><span class="pcoded-mtext">Uang Setor Bank</span></a>
                        </li>
                        @endif

                        <li
                            class="nav-item {{ Request::segment(2) === 'pelanggan' || Request::segment(2) === 'create_pelanggan' || Request::segment(2) === 'edit_pelanggan' ? 'active' : '' }}">
                            <a href="{{ route('admin.pelanggan') }}" class="nav-link "><span class="pcoded-micon"><i
                                        class="feather icon-user"></i></span><span class="pcoded-mtext">Data Pelanggan
                                    Kulit</span></a>
                        </li>

                        <li
                            class="nav-item {{ Request::segment(2) === 'kulit' || Request::segment(2) === 'input_kulit' || Request::segment(2) === 'detail_kulit' || Request::segment(2) === 'edit_kulit' ? 'active' : '' }}">
                            <a href="{{ route('admin.kulit') }}" class="nav-link "><span class="pcoded-micon"><i
                                        class="feather icon-layers"></i></span><span class="pcoded-mtext">Stok
                                    Kulit</span></a>
                        </li>

                        {{-- <li class="nav-item {{ Request::segment(2) === 'kulit_bulanan' ? 'active' : '' }}">
                            <a href="{{ route('admin.kulit_bulanan') }}" class="nav-link "><span
                                    class="pcoded-micon"><i class="feather icon-box"></i></span><span
                                    class="pcoded-mtext">Stok Kulit (Bulanan)</span></a>
                        </li> --}}

                        <li
                            class="nav-item {{ Request::segment(2) === 'kedelai' || Request::segment(2) === 'input_kedelai' || Request::segment(2) === 'edit_kedelai' ? 'active' : '' }}">
                            <a href="{{ route('admin.kedelai') }}" class="nav-link "><span class="pcoded-micon"><i
                                        class="feather icon-inbox"></i></span><span class="pcoded-mtext">Stok
                                    Kedelai</span></a>
                        </li>

                        <li
                            class="nav-item {{ Request::segment(2) === 'karyawan' || Request::segment(2) === 'create_karyawan' || Request::segment(2) === 'edit_karyawan' ? 'active' : '' }}">
                            <a href="{{ route('admin.karyawan') }}" class="nav-link "><span class="pcoded-micon"><i
                                        class="feather icon-user"></i></span><span class="pcoded-mtext">Data
                                    Karyawan</span></a>
                        </li>

                        <li
                            class="nav-item {{ Request::segment(2) === 'gaji' || Request::segment(2) === 'create_gaji' || Request::segment(2) === 'input_gaji' || Request::segment(2) === 'edit_gaji' ? 'active' : '' }}">
                            <a href="{{ route('admin.gaji') }}" class="nav-link "><span class="pcoded-micon"><i
                                        class="feather icon-file-text"></i></span><span
                                    class="pcoded-mtext">Gaji</span></a>
                        </li>

                        <li
                            class="nav-item {{ Request::segment(2) === 'tipe' || Request::segment(2) === 'create_tipe' || Request::segment(2) === 'edit_tipe' ? 'active' : '' }}">
                            <a href="{{ route('admin.tipe') }}" class="nav-link "><span class="pcoded-micon"><i
                                        class="feather icon-server"></i></span><span class="pcoded-mtext">Tipe
                                    Sales</span></a>
                        </li>

                        <li
                            class="nav-item {{ Request::segment(2) === 'sales' || Request::segment(2) === 'create_sales' || Request::segment(2) === 'edit_sales' ? 'active' : '' }}">
                            <a href="{{ route('admin.sales') }}" class="nav-link "><span class="pcoded-micon"><i
                                        class="feather icon-users"></i></span><span class="pcoded-mtext">Data
                                    Sales</span></a>
                        </li>

                        <li
                            class="nav-item {{ Request::segment(2) === 'admin' || Request::segment(2) === 'create_admin' || Request::segment(2) === 'edit_admin' ? 'active' : '' }}">
                            <a href="{{ route('admin.admin') }}" class="nav-link "><span class="pcoded-micon"><i
                                        class="feather icon-user"></i></span><span class="pcoded-mtext">Data
                                    Admin</span></a>
                        </li>

                        <li
                            class="nav-item {{ Request::segment(2) === 'setting' || Request::segment(2) === 'create_harga' || Request::segment(2) === 'edit_harga' ? 'active' : '' }}">
                            <a href="{{ route('admin.setting') }}" class="nav-link "><span class="pcoded-micon"><i
                                        class="feather icon-settings"></i></span><span class="pcoded-mtext">Setting
                                    Harga</span></a>
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
            <a href="index.html" class="b-brand">
                <div class="b-bg">
                    <i class="feather icon-trending-up"></i>
                </div>
                <span class="b-title">Super Dangsul</span>
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
                                <img src="{{ asset('images/logo.png') }}">
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

    @yield('script')

    <script type="text/javascript">
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });

        $(".datepicker-month").datepicker({
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#table_id').DataTable();
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
