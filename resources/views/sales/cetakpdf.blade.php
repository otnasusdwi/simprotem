<!DOCTYPE html>
<html>
<head>
    <title>Laporan Tempe Super Dangsul  </title>
    <style type="text/css">
        table {
            border-collapse: collapse;
            width: 100&;
            font-size: 13px;
            text-align: center;
        }
        
        table, th, td {
            /* border: 1px solid black; */
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            padding: 2px;
        }
        
    </style>
</head>
<body>
    @foreach($data as $index => $row)
    <hr style="border: 0; border-top: 0px;"><br><br>
    <b>
        {{ Auth::user()->name }} | 
        HARI / TANGGAL :
        {{ \Carbon\Carbon::parse($row->tgl_laporan)->translatedFormat('l, d F Y - H:i:s') }}
    </b>
    <br>
    <table>
        <thead>
            <tr>   
                <td>
                    <b>HARGA</b>
                </td>     
                <td></td>
                <td>
                    <b>SEDIA</b>
                </td>     
                <td></td>                                              
                <td>
                    <b>BAWA</b>
                </td>
                <td>
                    <b>TAMBAH</b>
                </td>
                <td></td>
                <td>
                    <b>SISA MUDA</b>
                </td>
                <td></td>
                <td>
                    <b>SISA TUA</b>
                </td>
                <td></td>
                <td>
                    <b>LAKU</b>
                </td>
                <td></td>
                <td></td>
                <th style="text-align: right;">
                    <b>JUMLAH</b>
                </td>
            </tr>
        </tdead>
        <tbody>
            @for ($i = 0; $i < count($item_laporan[$index]); $i++)
            <tr>
                <td style="color: black; font-weight: bold;">
                    {{ number_format($item_laporan[$index][$i]->harga,0,',','.') }}
                </td>
                <td> = </td>
                <td style="color: black; font-weight: bold;">
                    {{ number_format($item_monitoring[$index][$i]->sedia,0,',','.') }}
                </td>
                <td>  </td>
                <td style="color: black; font-weight: bold;">
                    {{ $item_laporan[$index][$i]->bawa }}
                </td>
                <td style="color: black; font-weight: bold;">
                    {{ $item_laporan[$index][$i]->tambah }}
                </td>
                <td> -&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( </td>
                <td style="color: black; font-weight: bold;">
                    {{ $item_laporan[$index][$i]->sisa_muda }}
                </td>
                <td> + </td>
                <td style="color: black; font-weight: bold;">
                    {{ $item_laporan[$index][$i]->sisa_tua }}
                </td>
                <td> )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;= </td>
                <td style="color: black; font-weight: bold;">
                    {{ $item_laporan[$index][$i]->laku }}
                </td>
                <td> x&nbsp;&nbsp;{{$item_laporan[$index][$i]->harga}}&nbsp;&nbsp;</td>
                <td> = </td>
                <td style="color: black; font-weight: bold;text-align: right;">
                    Rp {{ number_format($item_laporan[$index][$i]->harga * $item_laporan[$index][$i]->laku,0,',','.') }},-
                </td>
                
            </tr>
            @endfor
            <tr>
                <td colspan="13" style="color: black; font-weight: bold;text-align: right;">JUMLAH LAKU</td>
                <td> = </td>
                <td style="color: black; font-weight: bold;text-align: right;">Rp {{ number_format($row->jumlah_laku,0,',','.') }},-</td>
            </tr>
            <tr>
                <td colspan="13" style="color: black; font-weight: bold;text-align: right;">MARGIN SALES 10%</td>
                <td> = </td>
                <td style="color: black; font-weight: bold;text-align: right;">Rp {{ number_format($row->marginsales,0,',','.') }},-</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <td>SETORAN</td>
                <td> =&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;</td>
                <td>JUMLAH LAKU</td>
                <td>&nbsp;&nbsp;-&nbsp;&nbsp;</td>
                <td>MARGIN SALES</td>
                <td>&nbsp;&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td>
                    @if ($row->hutang_baru != 0)
                    &nbsp;&nbsp;-&nbsp;&nbsp;
                    @else
                    &nbsp;&nbsp;+&nbsp;&nbsp;
                    @endif
                </td>
                <td>PIUTANG</td>
            </tr>
        </tdead>
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
            </tr>
        </tbody>
    </table>
    <br>
    <h4 style="margin: auto; width: 30%; border: 2px solid black; padding: 3px; text-align: center;">
        <strong>Rp {{ number_format($row->setoran,0,',','.') }},-</strong>
    </h4>
    <br>
    <table>
        <thead>
            <tr>
                <th colspan="2" class="text-center">
                    <b>PIUTANG</b>
                </td>
                <th rowspan="2" class="text-center" style="vertical-align: middle;">
                    <b>TOTAL HUTANG</b>
                </td>
            </tr>
            <tr>
                <th class="text-center">
                    <b>HUTANG BARU</b>
                </td>
                <th class="text-center">
                    <b>PELUNASAN</b>
                </td>
            </tr>
        </tdead>
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
    <br><br><br>
    @endforeach
</body>
</html>