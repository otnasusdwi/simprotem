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
                                        <h5 class="m-b-10">Kulit</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="javascript:">Data Kulit</a></li>
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
                                                <form method="get" action="" style="width: 100%;">
                                                    <div class="row">
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="form-group">
                                                                <select class="form-control" id="exampleFormControlSelect1"
                                                                    name="month" required="required"
                                                                    value="{{ $get->month }}">
                                                                    <option value="" disabled selected>- Pilih Bulan -
                                                                    </option>
                                                                    <option value="1"
                                                                        @if ($get->month == 1) selected @endif>
                                                                        Januari</option>
                                                                    <option value="2"
                                                                        @if ($get->month == 2) selected @endif>
                                                                        Februari</option>
                                                                    <option value="3"
                                                                        @if ($get->month == 3) selected @endif>
                                                                        Maret</option>
                                                                    <option value="4"
                                                                        @if ($get->month == 4) selected @endif>
                                                                        April</option>
                                                                    <option value="5"
                                                                        @if ($get->month == 5) selected @endif>
                                                                        Mei</option>
                                                                    <option value="6"
                                                                        @if ($get->month == 6) selected @endif>
                                                                        Juni</option>
                                                                    <option value="7"
                                                                        @if ($get->month == 7) selected @endif>
                                                                        Juli</option>
                                                                    <option value="8"
                                                                        @if ($get->month == 8) selected @endif>
                                                                        Agustus</option>
                                                                    <option value="9"
                                                                        @if ($get->month == 9) selected @endif>
                                                                        September</option>
                                                                    <option value="10"
                                                                        @if ($get->month == 10) selected @endif>
                                                                        Oktober</option>
                                                                    <option value="11"
                                                                        @if ($get->month == 11) selected @endif>
                                                                        November</option>
                                                                    <option value="12"
                                                                        @if ($get->month == 12) selected @endif>
                                                                        Desember</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4">
                                                            <div class="form-group">
                                                                <select class="form-control" id="exampleFormControlSelect1"
                                                                    name="year" required="required"
                                                                    value="{{ $get->year }}">
                                                                    <option value="" disabled selected>- Pilih Tahun -
                                                                    </option>
                                                                    @foreach ($years as $year)
                                                                        <option
                                                                            value="{{ $year }}"@if ($get->tahun == $year) selected @endif>
                                                                            {{ $year }}</option>
                                                                    @endforeach
                                                                    {{-- @for ($i = 1; $i < 11; $i++) <option
																						  value="{{ 2018+$i }}" @if ($get->year == 2018 + $i)
																						  selected @endif>{{ 2018+$i }}</option>
																						  @endfor --}}
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-4 col-md-4">
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
                                            @if ($get->month && $get->year)
                                                <h5>Data Kulit Bulan {{ $get->month }} Tahun {{ $get->year }}</h5>
                                            @else
                                                <h5>Data Kulit Bulan ini</h5>
                                            @endif
                                            <div class="card-block px-0 py-3">
                                                @if (count($kulit[0]) == 0)
                                                    <div class="text-center">
                                                        <h6>Belum ada data</h6>
                                                    </div>
                                                @else
                                                    <div class="table-responsive">
                                                        <table class="table table-hover text-center">
                                                            <thead>
                                                                <tr class="unread">
                                                                    <th>
                                                                        <h6 class="mb-1"><b>No</b></h6>
                                                                    </th>
                                                                    <th>
                                                                        <h6 class="mb-1"><b>Nama</b></h6>
                                                                    </th>
                                                                    <th>
                                                                        <h6 class="mb-1"><b>Kulit</b></h6>
                                                                    </th>
                                                                    <th style="text-align: right;">
                                                                        <h6 class="mb-1"><b>Harga</b></h6>
                                                                    </th>
                                                                    <th style="text-align: right;">
                                                                        <h6 class="mb-1"><b>Tagihan/Tabungan <br>Bulan
                                                                                Lalu</b>
                                                                        </h6>
                                                                    </th>
                                                                    <th style="text-align: right;">
                                                                        <h6 class="mb-1"><b>Total Tagihan</b></h6>
                                                                    </th>
                                                                    <th style="text-align: right;">
                                                                        <h6 class="mb-1"><b>Bayar</b></h6>
                                                                    </th>
                                                                    <th style="text-align: right;">
                                                                        <h6 class="mb-1"><b>Kurang</b></h6>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $sum_kulit = 0;
                                                                    $sum_harga = 0;
                                                                    $sum_tagihan = 0;
                                                                    $sum_tabungan = 0;
                                                                    $sum_bayar = 0;
                                                                    $sum_kurang = 0;
                                                                    $sum_tabungann = 0;
                                                                    $total_tagihan = 0;
                                                                    $total_tabungan = 0;
                                                                @endphp
                                                                @for ($i = 0; $i < count($kulit); $i++)
                                                                    <tr class="unread">
                                                                        <td>
                                                                            <h6 class="mb-1">{{ $i + 1 }}</h6>
                                                                        </td>
                                                                        <td>
                                                                            <h6 class="mb-1">
                                                                                {{ $kulit[$i][0]['nama_pelanggan'] }}
                                                                            </h6>
                                                                        </td>
                                                                        <td>
                                                                            <h6 class="mb-1">
                                                                                {{ $kulit[$i][0]['total_kulit'] }}</h6>
                                                                        </td>
                                                                        <td style="text-align: right;">
                                                                            <h6 class="mb-1">Rp
                                                                                {{ number_format($kulit[$i][0]['total_harga'], 0, ',', '.') }},-
                                                                            </h6>
                                                                        </td>
                                                                        <td style="text-align: right;">
                                                                            @if ($tagihan[$i] > 1)
                                                                                <h6 class="mb-1">Rp
                                                                                    {{ number_format($tagihan[$i], 0, ',', '.') }},-
                                                                                </h6>
                                                                                @php $sum_tagihan += $tagihan[$i]; @endphp
                                                                            @elseif($tagihan[$i] == 0)
                                                                                <h6 class="mb-1">Rp
                                                                                    {{ number_format(0, 0, ',', '.') }},-</h6>
                                                                            @else
                                                                                <h6 class="mb-1">(<i>Tabungan</i>) Rp
                                                                                    {{ number_format($tagihan[$i] * -1, 0, ',', '.') }},-
                                                                                </h6>
                                                                                @php $sum_tabungan += $tagihan[$i] * -1; @endphp
                                                                            @endif
                                                                        </td>
                                                                        <td style="text-align: right;">
                                                                            @php
                                                                                $tottag =
                                                                                    $tagihan[$i] +
                                                                                    $kulit[$i][0]['total_harga'];
                                                                            @endphp
                                                                            @if ($tottag < 0)
                                                                                <h6 class="mb-1">(<i>Tabungan</i>) Rp
                                                                                    {{ number_format($tottag * -1, 0, ',', '.') }},-
                                                                                </h6>
                                                                            @else
                                                                                <h6 class="mb-1">Rp
                                                                                    {{ number_format($tottag, 0, ',', '.') }},-
                                                                                </h6>
                                                                                @php
                                                                                    $total_tagihan =
                                                                                        $total_tagihan + $tottag;
                                                                                @endphp
                                                                            @endif
                                                                        </td>
                                                                        <td style="text-align: right;">
                                                                            <h6 class="mb-1">Rp
                                                                                {{ number_format($kulit[$i][0]['total_bayar'], 0, ',', '.') }},-
                                                                            </h6>
                                                                        </td>
                                                                        <td style="text-align: right;">
                                                                            @php
                                                                                $kurang =
                                                                                    $kulit[$i][0]['total_bayar'] -
                                                                                    $tottag;
                                                                            @endphp
                                                                            @if ($kurang > 1)
                                                                                <h6 class="mb-1">(<i>Tabungan</i>) Rp
                                                                                    {{ number_format($kurang, 0, ',', '.') }},-
                                                                                </h6>
                                                                                @php
                                                                                    $total_tabungan += $kurang;
                                                                                @endphp
                                                                            @else
                                                                                <h6 class="mb-1">Rp
                                                                                    {{ number_format($kurang * -1, 0, ',', '.') }},-
                                                                                </h6>
                                                                            @endif
                                                                            {{-- <h6 class="mb-1">Rp {{ number_format(($kurang),0,',','.') }},- </h6> --}}
                                                                        </td>
                                                                    </tr>
                                                                    @php
                                                                        $sum_kulit += $kulit[$i][0]['total_kulit'];
                                                                        $sum_harga += $kulit[$i][0]['total_harga'];
                                                                        $sum_bayar += $kulit[$i][0]['total_bayar'];
                                                                    @endphp
                                                                @endfor
                                                            </tbody>
                                                            <tfoot>
                                                                <tr class="unread">
                                                                    <th>
                                                                        <h6 class="mb-1"><b></b></h6>
                                                                    </th>
                                                                    <th>
                                                                        <h6 class="mb-1"><b></b></h6>
                                                                    </th>
                                                                    <th>
                                                                        <h6 class="mb-1">
                                                                            <b>{{ number_format($sum_kulit, 0, ',', '.') }}</b>
                                                                        </h6>
                                                                    </th>
                                                                    <th style="text-align: right;">
                                                                        <h6 class="mb-1"><b>Rp
                                                                                {{ number_format($sum_harga, 0, ',', '.') }},-</b>
                                                                        </h6>
                                                                    </th>
                                                                    <th style="text-align: right;">
                                                                        <h6 class="mb-1">
                                                                            <b>
                                                                                <i>(Tagihan)</i> Rp
                                                                                {{ number_format($sum_tagihan, 0, ',', '.') }},-
                                                                                <br>
                                                                                <i>(Tabungan)</i> Rp
                                                                                {{ number_format($sum_tabungan, 0, ',', '.') }},-
                                                                            </b>
                                                                        </h6>
                                                                    </th>
                                                                    <th style="text-align: right;">
                                                                        <h6 class="mb-1">
                                                                            <b>
                                                                                <i>(Tagihan)</i> Rp
                                                                                {{ number_format($total_tagihan, 0, ',', '.') }},-
                                                                                <br>
                                                                                <i>(Tabungan)</i> Rp
                                                                                {{ number_format($sum_tabungan, 0, ',', '.') }},-
                                                                            </b>
                                                                        </h6>
                                                                    </th>
                                                                    <th style="text-align: right;">
                                                                        <h6 class="mb-1"><b>Rp
                                                                                {{ number_format($sum_bayar, 0, ',', '.') }},-</b>
                                                                        </h6>
                                                                    </th>
                                                                    <th style="text-align: right;">
                                                                        <h6 class="mb-1">
                                                                            <b>
                                                                                <i>(Kurang)</i> Rp
                                                                                {{ number_format($total_tagihan - $sum_bayar, 0, ',', '.') }},-
                                                                                <br>
                                                                                <i>(Tabungan)</i> Rp
                                                                                {{ number_format($total_tabungan, 0, ',', '.') }},-
                                                                            </b>
                                                                        </h6>
                                                                    </th>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                @endif
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
    @endsection
