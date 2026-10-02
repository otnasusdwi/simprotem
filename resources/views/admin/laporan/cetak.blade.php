<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table,
        td,
        th {
            border: 1px solid black;
            padding: 5px;
        }

    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th rowspan="2">Tangal Laporan</th>
                <th rowspan="2">No</th>
                <th rowspan="2">Nama Sales</th>
                <th rowspan="2">Tipe Sales</th>
                <th rowspan="2">Laku</th>
                <th rowspan="2">Persen</th>
                <th rowspan="2">Margin</th>
                <th rowspan="2">Setelah Margin</th>
                <th rowspan="2">Hutang Baru</th>
                <th rowspan="2">Pelunasan</th>
                <th rowspan="2">Seharusnya Setor</th>
                <th rowspan="2">Setelah Hutang/Bayar</th>
                <th rowspan="2">Tanggal Bayar</th>
                <th></th>
                @foreach($harga as $hrg)
                <th colspan="5">
                    {{ $hrg->harga }}
                </th>
                @endforeach

                <th rowspan="2">Saldo</th>
            </tr>
            <tr>
                {{-- <td>Tangal Laporan</td>
                <td>No</td>
                <td>Nama Sales</td>
                <td>Laku</td>
                <td>Persen</td>
                <td>Margin</td>
                <td>Setelah Margin</td>
                <td>Hutang Baru</td>
                <td>Pelunasan</td>
                <td>Seharusnya Setor</td>
                <td>Setelah Hutang/Bayar</td> --}}
                <td></td>
                @foreach($harga as $hrg)
                <td>Bawa</td>
                <td>Laku</td>
                <td>Sisa Muda</td>
                <td>Sisa Tua</td>
                <td>Setor</td>
                @endforeach
                {{-- <td>Saldo</td> --}}
            </tr>
        </thead>
        <tbody>
            @foreach($laporan as $index => $row)
            <tr>
                <td>{{$row->tgl_laporan}}</td>
                <td>{{ $index+1 }}</td>
                <td>{{ $row->name }}</td>
                <td>
                    @foreach($tipe as $i => $tp)
                    @if ($row->id_tipe == $tp->id_tipe )
                    {{$tp->tipe}}
                    @endif
                    @endforeach
                </td>
                <td>{{ $row->jumlah_laku }}</td>
                <td>{{ $row->jumlah_laku / 100 }}</td>
                <td>{{ $row->marginsales }}</td>
                <td>{{ $row->jumlah_laku - $row->marginsales }}</td>
                <td>{{ $row->hutang_baru }}</td>
                <td>{{ $row->pelunasan }}</td>
                <td>{{ $row->jumlah_laku - $row->marginsales }}</td>
                <td>{{ $row->setoran }}</td>
                <td>{{ $row->acc }}</td>
                <td></td>
                @php
                $saldo = 0;
                @endphp
                @foreach($item_laporan as $itm)
                @if ($itm->id_laporan == $row->id_laporan)
                @php
                $saldo = $saldo + ($itm->harga * $itm->laku);
                @endphp
                <td>{{$itm->bawa}}</td>
                <td>{{$itm->laku}}</td>
                <td>{{$itm->sisa_muda}}</td>
                <td>{{$itm->sisa_tua}}</td>
                <td>
                    {{ $itm->harga * $itm->laku }}
                </td>
                @endif
                @endforeach

                {{-- @for ($j = 0; $j < count($item_laporan[$index]); $j++)
                        $saldo = $saldo + ($item_laporan[$index][$j]->harga * $item_laporan[$index][$j]->laku); @endphp
                        <td>{{$item_laporan[$index][$j]->bawa}}</td>
                        <td>{{$item_laporan[$index][$j]->laku}}</td>
                        <td>{{$item_laporan[$index][$j]->sisa_muda}}</td>
                        <td>{{$item_laporan[$index][$j]->sisa_tua}}</td>
                        <td>
                            {{ $item_laporan[$index][$j]->harga * $item_laporan[$index][$j]->laku }}
                        </td>
                @endfor --}}
                <td>{{ $saldo }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
