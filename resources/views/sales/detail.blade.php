@extends('../layouts.front')
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
                                    <li class="breadcrumb-item"><a href="javascript:">Detail Laporan</a></li>
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
                                            <div class="col-xl-6 col-md-6">
                                                <div class="form-group">
                                                    <h5>
                                                        <strong>HARI / TANGGAL : </strong>
                                                        {{ $tgl_laporan }}<br><br>
                                                        @if ($status == 0)
                                                        <span style="color: red;text-align: center;""><strong>BELUM DIBAYAR</strong></span>
                                                        @else
                                                        <span style="color: green;text-align: center;"">
                                                            <strong>LUNAS</strong> ( {{ $acc }} )
                                                        </span>
                                                        @endif
                                                    </h5>
                                                </div>
                                            </div>
                                            
                                            <div class="col-xl-6 col-md-6" style="text-align: right;">
                                                <a target="_blank" href="{{ route('sales.pdf') }}?id_laporan={{ $id_laporan}}" type="button" class="btn theme-bg2" style="color: white;">CETAK</a>
                                                <a href="{{ route('sales.pdf-kasir') }}?id_laporan={{ $id_laporan}}" type="button" class="btn btn-primary" style="color: white;">CETAK KASIR</a>
                                            </div>
                                        </div>
                                        <div class="card-block px-0 py-3">
                                            <div class="table-responsive">
                                                <table class="table table-hover text-center">
                                                    <thead>
                                                        <tr class="unread">   
                                                            <th>
                                                                <h6 class="mb-1"><b>HARGA</b></h6>
                                                            </th>     
                                                            <th></th>
                                                            <th>
                                                                <h6 class="mb-1"><b>SEDIA</b></h6>
                                                            </th>                                           
                                                            <th>
                                                                <h6 class="mb-1"><b>BAWA</b></h6>
                                                            </th>   
                                                            <th>
                                                                <h6 class="mb-1"><b>TAMBAH</b></h6>
                                                            </th>     
                                                            <th></th>
                                                            <th>
                                                                <h6 class="mb-1"><b>SISA MUDA</b></h6>
                                                            </th>
                                                            <th></th>
                                                            <th>
                                                                <h6 class="mb-1"><b>SISA TUA</b></h6>
                                                            </th>
                                                            <th></th>
                                                            <th>
                                                                <h6 class="mb-1"><b>LAKU</b></h6>
                                                            </th>
                                                            <th></th>
                                                            <th></th>
                                                            <th style="text-align: right;">
                                                                <h6 class="mb-1"><b>JUMLAH</b></h6>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        @foreach($data as $index => $row)
                                                        <tr>
                                                            <td style="color: black; font-weight: bold;">
                                                                {{ number_format($row->harga,0,',','.') }}
                                                            </td>
                                                            <td> = </td>
                                                            <td style="color: black; font-weight: bold;">
                                                                {{ $sedia[$index] }}
                                                            </td>
                                                            <td style="color: black; font-weight: bold;">
                                                                {{ $row->bawa }}
                                                            </td>
                                                            <td style="color: black; font-weight: bold;">
                                                                {{ $tambah[$index] }}
                                                            </td>
                                                            <td> -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( </td>
                                                            <td style="color: black; font-weight: bold;">
                                                                {{ $row->sisa_muda }}
                                                            </td>
                                                            <td> + </td>
                                                            <td style="color: black; font-weight: bold;">
                                                                {{ $row->sisa_tua }}
                                                            </td>
                                                            <td> )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;= </td>
                                                            <td style="color: black; font-weight: bold;">
                                                                {{ $row->laku }}
                                                            </td>
                                                            <td> x&nbsp;&nbsp;{{$row->harga}}&nbsp;&nbsp;</td>
                                                            <td> = </td>
                                                            <td style="color: black; font-weight: bold;text-align: right;">
                                                                Rp {{ number_format($row->harga * $row->laku,0,',','.') }},-
                                                            </td>
                                                        </tr>
                                                        
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="12" style="color: black; font-weight: bold;text-align: right;">JUMLAH LAKU</td>
                                                            <td> = </td>
                                                            <td style="color: black; font-weight: bold;text-align: right;">Rp {{ number_format($row->jumlah_laku,0,',','.') }},-</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="12" style="color: black; font-weight: bold;text-align: right;">MARGIN SALES 10%</td>
                                                            <td> = </td>
                                                            <td style="color: black; font-weight: bold;text-align: right;">Rp {{ number_format($row->marginsales,0,',','.') }},-</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <br><br>
                                            
                                            <div class="table-responsive">
                                                <table class="table table-hover text-center" style="color: black; font-weight: bold;">
                                                    <thead>
                                                        <tr>
                                                            <th>SETORAN</th>
                                                            <th> =&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;</th>
                                                            <th>JUMLAH LAKU</th>
                                                            <th>&nbsp;&nbsp;-&nbsp;&nbsp;</th>
                                                            <th>MARGIN SALES</th>
                                                            <th>&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                            <th>
                                                                @if ($row->hutang_baru != 0)
                                                                &nbsp;&nbsp;-&nbsp;&nbsp;
                                                                @else
                                                                &nbsp;&nbsp;+&nbsp;&nbsp;
                                                                @endif
                                                            </th>
                                                            <th>
                                                                PIUTANG
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td> =&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;</td>
                                                            <td><strong>Rp {{ number_format($row->jumlah_laku,0,',','.') }},-</strong></td>
                                                            <td>&nbsp;&nbsp;-&nbsp;&nbsp;</td>
                                                            <td><strong>Rp {{ number_format($row->marginsales,0,',','.') }},-</strong></td>
                                                            <td>&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                            <td>
                                                                @if ($row->hutang_baru != 0)
                                                                &nbsp;&nbsp;-&nbsp;&nbsp;
                                                                @else
                                                                &nbsp;&nbsp;+&nbsp;&nbsp;
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <strong>
                                                                    @if ($row->hutang_baru != 0)
                                                                    Rp {{ number_format($row->hutang_baru,0,',','.') }},-
                                                                    @else
                                                                    Rp {{ number_format($row->pelunasan,0,',','.') }},-
                                                                    @endif
                                                                </strong>
                                                            </td>
                                                            {{-- <td><strong>Rp {{ number_format(Auth::user()->piutang,0,',','.') }},-</strong></td> --}}
                                                        </tr>
                                                        <tr>
                                                            <td colspan="8" style="text-align: left;">
                                                                <br>
                                                                <h3 style="margin: auto; width: 45%; border: 3px solid black; padding: 10px; text-align: center;">
                                                                    <strong>Rp {{ number_format($row->setoran,0,',','.') }},-</strong>
                                                                </h3>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            
                                            <br><br>
                                            
                                            <div class="table-responsive">
                                                <table class="table table-hover text-center" style="color: black; font-weight: bold;">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="2" class="text-center">
                                                                <h6 class="mb-1"><b>PIUTANG</b></h6>
                                                            </th>
                                                            <th rowspan="2" class="text-center" style="vertical-align: middle;">
                                                                <h6 class="mb-1"><b>TOTAL HUTANG</b></h6>
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th class="text-center">
                                                                <h6 class="mb-1"><b>HUTANG BARU</b></h6>
                                                            </th>
                                                            <th class="text-center">
                                                                <h6 class="mb-1"><b>PELUNASAN</b></h6>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                Rp {{ number_format($row->hutang_baru,0,',','.') }},-
                                                            </td>
                                                            <td>
                                                                RP {{ number_format($row->pelunasan,0,',','.') }},-
                                                            </td>
                                                            <td>
                                                                Rp {{ number_format($row->piutang,0,',','.') }},-
                                                            </td>
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
</div>
<!-- [ Main Content ] end -->
@endsection