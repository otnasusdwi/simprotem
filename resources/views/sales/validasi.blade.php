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
                                    <li class="breadcrumb-item"><a href="#">Laporan Harian</a></li>
                                    <li class="breadcrumb-item"><a href="#">Validasi</a></li>
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
                                    <div class="text-center">
                                        <div class="card-header">
                                            <h3 style="color: red;"><strong>PERHATIAN!</strong></h3>
                                            <h4>
                                                <strong>Harap cek kembali data laporan Anda!</strong>
                                            </h4>
                                            <h5>
                                                Jika data sudah benar, klik tombol <strong>Lapor</strong>, 
                                                jika data belum benar, klik tombol Kembali untuk mengedit laporan
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--[ Recent Users ] start-->
                            <div class="col-xl-12 col-md-12">
                                <div class="card Recent-Users">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-xl-12 col-md-12">
                                                <div class="form-group">
                                                    <h5>
                                                        HARI / TANGGAL :
                                                        {{ \Carbon\Carbon::parse($tgl_laporan)->translatedFormat('l, d F Y - H:i:s') }}
                                                    </h5>
                                                </div>
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
                                                        @for ($i = 0; $i < count($harga); $i++)
                                                        <tr>
                                                            <td style="color: black; font-weight: bold;">
                                                                {{ number_format($harga[$i],0,',','.') }}
                                                            </td>
                                                            <td> = </td>
                                                            <td style="color: black; font-weight: bold;">
                                                                {{ $sedia[$i] }}
                                                            </td>
                                                            <td style="color: black; font-weight: bold;">
                                                                {{ $bawa[$i] }}
                                                            </td>
                                                            <td style="color: black; font-weight: bold;">
                                                                {{ $tambah[$i] }}
                                                            </td>
                                                            <td> -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( </td>
                                                            <td style="color: black; font-weight: bold;">
                                                                {{ $sisa_muda[$i] }}
                                                            </td>
                                                            <td> + </td>
                                                            <td style="color: black; font-weight: bold;">
                                                                {{ $sisa_tua[$i] }}
                                                            </td>
                                                            <td> )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;= </td>
                                                            <td style="color: black; font-weight: bold;">
                                                                {{ $laku[$i] }}
                                                            </td>
                                                            <td> x&nbsp;&nbsp;{{$harga[$i]}}&nbsp;&nbsp;</td>
                                                            <td> = </td>
                                                            <td style="color: black; font-weight: bold;text-align: right;">
                                                                Rp {{ number_format($jumlah[$i],0,',','.') }},-
                                                            </td>
                                                        </tr>
                                                        @endfor
                                                        <tr>
                                                            <td colspan="12" style="color: black; font-weight: bold;text-align: right;">JUMLAH LAKU</td>
                                                            <td> = </td>
                                                            <td style="color: black; font-weight: bold;text-align: right;">Rp {{ number_format($jumlah_laku,0,',','.') }},-</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="12" style="color: black; font-weight: bold;text-align: right;">MARGIN SALES 10%</td>
                                                            <td> = </td>
                                                            <td style="color: black; font-weight: bold;text-align: right;">Rp {{ number_format($marginsales,0,',','.') }},-</td>
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
                                                                @if ($hutang_baru != 0)
                                                                &nbsp;&nbsp;-&nbsp;&nbsp;
                                                                @else
                                                                &nbsp;&nbsp;+&nbsp;&nbsp;
                                                                @endif
                                                            </th>
                                                            <th>PIUTANG</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td> =&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;</td>
                                                            <td><strong>Rp {{ number_format($jumlah_laku,0,',','.') }},-</strong></td>
                                                            <td>&nbsp;&nbsp;-&nbsp;&nbsp;</td>
                                                            <td><strong>Rp {{ number_format($marginsales,0,',','.') }},-</strong></td>
                                                            <td>&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                                            <td>
                                                                @if ($hutang_baru != 0)
                                                                &nbsp;&nbsp;-&nbsp;&nbsp;
                                                                @else
                                                                &nbsp;&nbsp;+&nbsp;&nbsp;
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <strong>
                                                                    @if ($hutang_baru != 0)
                                                                    Rp {{ number_format($hutang_baru,0,',','.') }},-
                                                                    @else
                                                                    Rp {{ number_format($pelunasan,0,',','.') }},-
                                                                    @endif
                                                                </strong>
                                                            </td>
                                                            {{-- <td><strong>Rp {{ number_format(Auth::user()->piutang,0,',','.') }},-</strong></td> --}}
                                                        </tr>
                                                        <tr>
                                                            <td colspan="8" style="text-align: left;">
                                                                <br>
                                                                <h3 style="margin: auto; width: 45%; border: 3px solid black; padding: 10px; text-align: center;">
                                                                    <strong>Rp {{ number_format($setoran,0,',','.') }},-</strong>
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
                                                                Rp {{ number_format($hutang_baru,0,',','.') }},-
                                                            </td>
                                                            <td>
                                                                RP {{ number_format($pelunasan,0,',','.') }},-
                                                            </td>
                                                            <td>
                                                                Rp {{ number_format($piutang,0,',','.') }},-
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <br>
                                                <div class="col-md-6 text-center" >
                                                    <button onclick="goBack()" class="btn theme-bg2" style="color: white;width: 250px;"><b>KEMBALI</b></button>
                                                </div>
                                                <div class="col-md-6 text-center" style="">
                                                    <form method="POST" action="{{ route('sales.input') }}">
                                                        @csrf
                                                        <input type="hidden" name="tgl_laporan" value="{{ $tgl_laporan }}">
                                                        <input type="hidden" name="hutang_baru" value="{{ $hutang_baru }}">
                                                        <input type="hidden" name="pelunasan" value="{{ $pelunasan }}">
                                                        <input type="hidden" name="jumlah_laku" value="{{ $jumlah_laku }}">
                                                        <input type="hidden" name="marginsales" value="{{ $marginsales }}">
                                                        <input type="hidden" name="setoran" value="{{ $setoran }}">
                                                        <input type="hidden" name="piutang" value="{{ $piutang }}">
                                                        @for ($i = 0; $i < count($harga); $i++)
                                                        <input type="hidden" name="harga[]" value="{{ $harga[$i] }}">
                                                        <input type="hidden" name="bawa[]" value="{{ $bawa[$i] }}">
                                                         <input type="hidden" name="tambah[]" value="{{ $tambah[$i] }}">
                                                        <input type="hidden" name="laku[]" value="{{ $laku[$i] }}">
                                                        <input type="hidden" name="sisa_muda[]" value="{{ $sisa_muda[$i] }}">
                                                        <input type="hidden" name="sisa_tua[]" value="{{ $sisa_tua[$i] }}">
                                                        @endfor
                                                        <button type="submit" class="btn theme-bg" style="color: white;width: 250px;"><b>LAPOR</b></button>
                                                    </form>
                                                </div>
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