<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="refresh" content="1;url={{ $_SERVER['HTTP_REFERER'] }}" />
    <title>Laporan Tempe Super Dangsul </title>
    <style type="text/css">
        body {
            font-family: "Trebuchet MS", Helvetica, sans-serif !important;
            font-size: 9px;
            font-weight: 400;
            margin: 2px;

        }

        table {
            /* background-color: red; */
            width: 80mm;
            /* border-collapse: collapse; */
            /* padding: 10px; */
            padding-left: 5px;
            padding-right: 31px;
            table-layout: fixed;
			margin: auto;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        p {
            margin: 2px;
            line-height: 20px;
        }

        @page {
            margin: 0px;
        }

        .rotate {
            transform: rotate(270deg);
        }

    </style>
</head>

<body class="text-center">
	<img src="{{ asset('images/favicon.ico') }}" alt="" width="60">
	<br>
	{{-- <h2>
		<strong>Laporan Tempe Superdangsul</strong>
	</h2> --}}
    <b>
        {{ Auth::user()->name }} <br>
        HARI / TANGGAL :
        {{ $tgl_laporan }}
    </b>
    <br>
	<p>-----------------------------------------------------------------------------</p>
	<br><br><br><br>
    <table>
        <thead>
            <tr>
                <td class="rotate" style="padding-left: 15px;">
                    <b>HARGA</b>
                </td>
                <td></td>
                <td class="rotate" style="padding-left: 15px;">
                    <b>SEDIA</b>
                </td>
                {{-- <td></td> --}}
                <td class="rotate" style="padding-left: 15px;">
                    <b>BAWA</b>
                </td>
                <td class="rotate" style="padding-left: 15px;">
                    <b>TAMBAH</b>
                </td>
                {{-- <td></td> --}}
                <td class="rotate" style="padding-left: 15px;">
                    <b>SISAMUDA</b>
                </td>
                <td></td>
                <td class="rotate" style="padding-left: 15px;">
                    <b>SISATUA</b>
                </td>
                {{-- <td></td> --}}
                <td class="rotate" style="padding-left: 15px;">
                    <b>LAKU</b>
                </td>
                <td></td>
                <td></td>
                <th style="text-align: right;padding-left: 15px;" class="rotate" >
                    <b>JUMLAH</b>
                </th>
            </tr>
        </thead>
        <tbody>

            @foreach($data as $index => $row)
            <tr>
                <td style="color: black; font-weight: bold;">
                    {{ number_format($row->harga,0,',','.') }}
                </td>
                <td></td>
                <td style="color: black; font-weight: bold;">
                    {{ $monitoring[$index] }}
                </td>
                {{-- <td> </td> --}}
                <td style="color: black; font-weight: bold;">
                    {{ $row->bawa }}
                </td>
                <td style="color: black; font-weight: bold;">
                    {{ $row->tambah }}
                </td>
                {{-- <td>  </td> --}}
                <td style="color: black; font-weight: bold;">
                    -&nbsp;({{ $row->sisa_muda }}
                </td>
                <td> + </td>
                <td style="color: black; font-weight: bold;">
                    {{ $row->sisa_tua }})&nbsp;=
                </td>
                {{-- <td>  </td> --}}
                <td style="color: black; font-weight: bold;">
                    {{ $row->laku }}
                </td>
                <td> x&nbsp;{{$row->harga}}&nbsp;</td>
                <td> = </td>
                <td style="color: black; font-weight: bold; text-align: right; float:right; margin-right: -7px;">
                    {{ number_format($row->harga * $row->laku,0,',','.') }}
                </td>
            </tr>
            @endforeach
            <tr></tr>
            <tr style="margin-top: 10px;">
                <td colspan="10" style="color: black; font-weight: bold;text-align: right;">JUMLAH LAKU</td>
                <td> = </td>
                <td style="color: black; font-weight: bold; text-align: right; float:right; margin-right: -7px;">
                    {{ number_format($row->jumlah_laku,0,',','.') }}</td>
            </tr>
            <tr>
                <td colspan="10" style="color: black; font-weight: bold;text-align: right;">MARGIN SALES 10%</td>
                <td> = </td>
                <td style="color: black; font-weight: bold;text-align: right;">
                    {{ number_format($row->marginsales,0,',','.') }}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <td>SETORAN</td>
                <td> =&nbsp;(&nbsp;</td>
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
                <td> =&nbsp;(&nbsp;</td>
                <td><strong>{{ number_format($row->jumlah_laku,0,',','.') }}</strong></td>
                <td>&nbsp;&nbsp;-&nbsp;&nbsp;</td>
                <td><strong>{{ number_format($row->marginsales,0,',','.') }}</strong></td>
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
                        {{ number_format($row->hutang_baru,0,',','.') }}
                        @else
                        {{ number_format($row->pelunasan,0,',','.') }}
                        @endif
                    </strong>
                </td>
            </tr>
            {{-- <tr>
                <td colspan="8" style="text-align: left;">
                    <br>
                    <h3 style="margin: auto; width: 30%; border: 3px solid black; padding: 10px; text-align: center;">
                        <strong>{{ number_format($row->setoran,0,',','.') }}</strong>
            </h3>
            </td>
            </tr> --}}
        </tbody>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <td><strong style="font-size: 14px;">{{ number_format($row->setoran,0,',','.') }}</strong></td>
            </tr>
        </thead>
    </table>
    {{-- <h4 style="margin: auto; width: 30%; border: 2px solid black; padding: 3px; text-align: center;">
        <strong>{{ number_format($row->setoran,0,',','.') }}</strong>
    </h4> --}}
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
                    {{ number_format($row->hutang_baru,0,',','.') }}
                </td>
                <td>
                    {{ number_format($row->pelunasan,0,',','.') }}
                </td>
                <td>
                    {{ number_format($row->piutang,0,',','.') }}
                </td>
            </tr>
        </tbody>
    </table>
    {{-- <br><br>
    <hr><br><br> --}}
	<p>-----------------------------------------------------------------------------</p>
	<br>
	<script>
        window.print();
    </script>

</body>

</html>
