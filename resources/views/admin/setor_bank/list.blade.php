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
                                        <h5 class="m-b-10">Uang Setor Bank</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="javascript:">Data Uang Setor Bank</a></li>
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
                                                                <select class="form-control" name="bulan" required>
                                                                    <option value="">Pilih Bulan</option>
                                                                    @foreach (range(1, 12) as $month)
                                                                        <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}"
                                                                            {{ request('bulan') == str_pad($month, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                                            {{ Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-2 col-md-2">
                                                            <div class="form-group">
                                                                <select class="form-control" name="tahun" required>
                                                                    <option value="">Pilih Tahun</option>
                                                                    @foreach (range(2025, date('Y') + 5) as $year)
                                                                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                                                            {{ $year }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-2 col-md-2">
                                                            <button type="submit" class="btn theme-bg"
                                                                style="color: white; width: 100%;">Lihat</button>
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
                                            @if (request('bulan') && request('tahun'))
                                                <h5>{{ Carbon\Carbon::createFromFormat('m-Y', request('bulan') . '-' . request('tahun'))->translatedFormat('F Y') }}</h5>
                                            @endif
                                        </div>
                                        @if (request('bulan') && request('tahun'))
                                            <div class="card-header">
                                                <div class="row">
                                                    @if (count($setor_bank) == 0)
                                                    <div class="col-xl-2 col-md-2">
                                                        <a href="{{ URL::to('admin/input_setor_bank?bulan=' . request('bulan') . '&tahun=' . request('tahun')) }}"
                                                            class="btn theme-bg"
                                                            style="color: white; width: 100%;">Input</a>
                                                    </div>
                                                    @else
                                                    <div class="col-xl-2 col-md-2">
                                                        <a href="{{ URL::to('admin/edit_setor_bank?bulan=' . request('bulan') . '&tahun=' . request('tahun')) }}"
                                                            class="btn btn-warning"
                                                            style="color: white; width: 100%;">Edit</a>
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
                                                                <h6 class="mb-1"><b>Tanggal Setor</b></h6>
                                                            </th>
                                                            <th style="text-align: right;">
                                                                <h6 class="mb-1"><b>Uang Masuk</b></h6>
                                                            </th>
                                                            <th style="text-align: right;">
                                                                <h6 class="mb-1"><b>Pengeluaran</b></h6>
                                                            </th>
                                                            <th style="text-align: right;">
                                                                <h6 class="mb-1"><b>Setor Bank</b></h6>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($setor_bank as $index => $row)
                                                            <tr class="unread">
                                                                <td>
                                                                    <h6 class="mb-1">{{ $index + 1 }}</h6>
                                                                </td>
                                                                <td>
                                                                    <h6 class="mb-1">
                                                                        {{ Carbon\Carbon::parse($row->tgl_setor)->translatedFormat('d F Y') }}
                                                                    </h6>
                                                                </td>
                                                                <td style="text-align: right;">
                                                                    <h6 class="mb-1">Rp
                                                                        {{ number_format($row->uang_masuk, 0, ',', '.') }},-
                                                                    </h6>
                                                                </td>
                                                                <td style="text-align: right;">
                                                                    <h6 class="mb-1">Rp
                                                                        {{ number_format($row->pengeluaran, 0, ',', '.') }},-
                                                                    </h6>
                                                                </td>
                                                                <td style="text-align: right;">
                                                                    <h6 class="mb-1">Rp
                                                                        {{ number_format($row->setor_bank, 0, ',', '.') }},-
                                                                    </h6>
                                                                </td>
                                                            </tr>
                                                            @if($loop->last)
                                                            <tr>
                                                                <td colspan="2">
                                                                    <h6 class="mb-1"><b>Jumlah</b></h6>
                                                                </td>
                                                                <td style="text-align: right;">
                                                                    <h6 class="mb-1"><b>Rp
                                                                            {{ number_format($setor_bank->sum('uang_masuk'), 0, ',', '.') }},
                                                                        -</b></h6>
                                                                </td>
                                                                <td style="text-align: right;">
                                                                    <h6 class="mb-1"><b>Rp
                                                                            {{ number_format($setor_bank->sum('pengeluaran'), 0, ',', '.') }},
                                                                        -</b></h6>
                                                                </td>
                                                                <td style="text-align: right;">
                                                                    <h6 class="mb-1"><b>Rp
                                                                            {{ number_format($setor_bank->sum('setor_bank'), 0, ',', '.') }},
                                                                        -</b></h6>
                                                                </td>
                                                            </tr>
                                                            @endif
                                                        @empty
                                                            <tr>
                                                                <td colspan="5">
                                                                    <h6 class="mb-1">Tidak ada data, silakan pilih <b>bulan setor</b> diatas & tambah data
                                                                        setor bank</h6>
                                                                </td>
                                                            </tr>
                                                        @endforelse
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
