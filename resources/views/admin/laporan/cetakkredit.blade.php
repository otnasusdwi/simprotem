<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 5px;
        }

        .container {
            max-width: 100%;
            /* margin: auto;
            background: #fff;
            padding: 20px; */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            text-align: center;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            font-size: 12px;
            border: 1px solid black;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            word-wrap: break-word;
        }

        th {
            background-color: #eaeaea;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h4>Debit Kredit {{ \Carbon\Carbon::parse(request('tgl'))->translatedFormat('F Y') }}</h4>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Keterangan</th>
                        <th class="text-right">Debit</th>
                        <th class="text-right">Kredit</th>
                        <th class="text-right">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Saldo Dalam 1 Bulan</td>
                        <td class="text-right">Rp {{ number_format($data['debit'], 0, ',', '.') }},-</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Pengeluaran Pabrik 1 Bulan</td>
                        <td></td>
                        <td class="text-right">Rp {{ number_format($data['kredit'], 0, ',', '.') }},-</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Pemakaian Dele 1 Bulan</td>
                        <td></td>
                        <td class="text-right">Rp {{ number_format($data['pemakaian_kedelai'], 0, ',', '.') }},-</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><b>Laba</b></td>
                        <td class="text-right"><b>Rp {{ number_format($data['debit'], 0, ',', '.') }},-</b></td>
                        <td class="text-right"><b>Rp
                                {{ number_format($data['kredit'] + $data['pemakaian_kedelai'], 0, ',', '.') }},-</b>
                        </td>
                        <td class="text-right"><b>Rp
                                {{ number_format($data['debit'] - ($data['kredit'] + $data['pemakaian_kedelai']), 0, ',', '.') }},-</b>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br />
        <h4>Rincian Anggaran Bulanan</h4>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Pengeluaran</th>
                        <th class="text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_rincian = 0;
                    @endphp
                    @foreach ($data['rincian'] as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td class="text-right">
                                @if ($item['id'] != 11)
                                    Rp {{ number_format($item['kredit'], 0, ',', '.') }},-
                                @else
                                    {{ $item['qty'] }}
                                @endif
                            </td>
                        </tr>
                        @php
                            if ($item['id'] != 11) {
                                $total_rincian += $item['kredit'];
                            }
                        @endphp
                    @endforeach
                    <tr>
                        <td><b>Total</b></td>
                        <td class="text-right"><b>Rp {{ number_format($total_rincian, 0, ',', '.') }},-</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
