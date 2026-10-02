<!DOCTYPE html>
<html>

<head>
    <title>Laporan Tempe Super Dangsul </title>
    <style type="text/css">
        table {
            border-collapse: collapse;
            width: 100&;
            font-size: 13px;
            text-align: center;
        }

        table,
        th,
        td {
            /* border: 1px solid black; */
            border-top: 1px solid black;
            border-bottom: 1px solid black;
            padding: 2px;
        }

    </style>
</head>

<body>
    <b>
        {{ Auth::user()->name }} <br>
        HARI / TANGGAL :
        {{ $tgl_laporan }}
    </b>

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

            @foreach($data as $index => $row)
            <tr>
                <td style="color: black; font-weight: bold;">
                    {{ number_format($row->harga,0,',','.') }}
                </td>
                <td> = </td>
                <td style="color: black; font-weight: bold;">
                    {{ $monitoring[$index] }}
                </td>
                <td> </td>
                <td style="color: black; font-weight: bold;">
                    {{ $row->bawa }}
                </td>
                <td style="color: black; font-weight: bold;">
                    {{ $row->tambah }}
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
                <td colspan="13" style="color: black; font-weight: bold;text-align: right;">JUMLAH LAKU</td>
                <td> = </td>
                <td style="color: black; font-weight: bold;text-align: right;">Rp
                    {{ number_format($row->jumlah_laku,0,',','.') }},-</td>
            </tr>
            <tr>
                <td colspan="13" style="color: black; font-weight: bold;text-align: right;">MARGIN SALES 10%</td>
                <td> = </td>
                <td style="color: black; font-weight: bold;text-align: right;">Rp
                    {{ number_format($row->marginsales,0,',','.') }},-</td>
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
            {{-- <tr>
                <td colspan="8" style="text-align: left;">
                    <br>
                    <h3 style="margin: auto; width: 30%; border: 3px solid black; padding: 10px; text-align: center;">
                        <strong>Rp {{ number_format($row->setoran,0,',','.') }},-</strong>
            </h3>
            </td>
            </tr> --}}
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
    <br><br>
    <hr><br><br>


</body>

</html>
