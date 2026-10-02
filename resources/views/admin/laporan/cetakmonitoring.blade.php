<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring_{{ request('from') }}_{{ request('to') }}</title>
    <style>
        body{font-family:Arial,sans-serif;margin:0;padding:10px}
        .report-container{width:100%;margin-bottom:30px}
        .table-container{overflow-x:auto}
        table{width:100%;border-collapse:collapse;text-align:center;font-size:9px;border:1px solid #000;table-layout:fixed}
        th,td{border:1px solid #000;padding:4px;word-wrap:break-word}
        th{background-color:#eaeaea;font-weight:bold}
        .total{font-weight:bold}
        .spacer{height:40px}
        
        /* Print Styles */
        @media print {
            @page {
                size: A4 landscape;
                margin: 1cm 1.5cm;
            }
            
            body {
                margin: 0;
                padding: 10px;
                font-size: 7px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .report-container {
                page-break-after: always;
                page-break-inside: avoid;
                margin-bottom: 0;
                width: 100%;
                padding: 8px 0;
                height: auto;
                max-height: calc(100vh - 2cm);
            }
            
            .report-container:last-child {
                page-break-after: avoid;
            }
            
            table {
                width: 100%;
                font-size: 7px;
                border: 1px solid #000;
                margin: 8px 0;
                page-break-inside: avoid;
                table-layout: fixed;
            }
            
            th, td {
                padding: 3px 2px;
                border: 1px solid #000;
                font-size: 7px;
                line-height: 1.2;
                word-wrap: break-word;
                overflow: hidden;
            }
            
            th {
                background-color: #eaeaea !important;
                font-weight: bold;
                padding: 4px 2px;
                font-size: 7px;
            }
            
            .total {
                font-weight: bold;
            }
            
            .spacer {
                display: none;
            }
            
            h4 {
                margin: 0 0 12px 0;
                font-size: 13px;
                page-break-after: avoid;
                text-align: center;
                font-weight: bold;
            }
            
            .table-container {
                margin: 8px 0;
                overflow: visible;
                width: 100%;
            }
            
            /* Compact spacing for sales rows */
            tbody tr:not(.total) td {
                padding: 2px;
                font-size: 7px;
            }
            
            /* Ensure monthly total row prints with proper styling */
            tr[style*="background-color:#ffebee"] {
                background-color: #ffebee !important;
                border-top: 2px solid #d32f2f !important;
            }
            
            /* Force table to fit page width */
            th:first-child, td:first-child {
                width: 3%;
            }
            
            th:nth-child(2), td:nth-child(2) {
                width: 12%;
            }
            
            /* Distribute remaining columns evenly */
            th:not(:first-child):not(:nth-child(2)), 
            td:not(:first-child):not(:nth-child(2)) {
                width: auto;
            }
        }
    </style>
</head>

<body>
@php
    $isAdmin = Auth::user()->level == 3;
    $totalKerugianBulan = 0; // Initialize monthly loss calculation
    $totalSediaBulan = 0; // Initialize monthly sedia total
    $totalLakuBulan = 0; // Initialize monthly laku total
@endphp

@foreach ($results as $resultIndex => $result)
    @php
        $hargaCount = count($result['harga']);
        $salesCount = count($result['sales']);
        $hasilKedelai = 0;
    @endphp
    
    <div class="report-container">
        <h4>{{ $result['tgl'] }}</h4>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th rowspan="2">NO</th>
                        <th rowspan="2">SALES</th>
                        <th colspan="{{ $hargaCount }}">SEDIA</th>
                        <th colspan="{{ $hargaCount }}">LAKU</th>
                    </tr>
                    <tr>
                        @foreach ($result['harga'] as $hrg)
                            <th>{{ $hrg->harga }}<br>{{ $hrg->berat }}</th>
                        @endforeach
                        @foreach ($result['harga'] as $hrg)
                            <th>{{ $hrg->harga }}<br>{{ $hrg->berat }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result['sales'] as $index => $sales)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $sales->name }}</td>
                            @foreach ($result['harga'] as $hrg)
                                <td>
                                    @foreach ($result['data'] as $row)
                                        @if ($row->id_user == $sales->id && $row->harga == $hrg->harga)
                                            {{ $row->sedia }}
                                            @break
                                        @endif
                                    @endforeach
                                </td>
                            @endforeach
                            @foreach ($result['harga'] as $hrg)
                                <td>
                                    @foreach ($result['data'] as $row)
                                        @if ($row->id_user == $sales->id && $row->harga == $hrg->harga)
                                            {{ $row->laku }}
                                            @break
                                        @endif
                                    @endforeach
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    
                    <tr class="total">
                        <td colspan="2">JUMLAH TOTAL</td>
                        @foreach ($result['harga'] as $i => $hrg)
                            <td>{{ $result['total_sedia'][$i] }}</td>
                        @endforeach
                        @foreach ($result['harga'] as $i => $hrg)
                            <td>{{ $result['total_laku'][$i] }}</td>
                        @endforeach
                    </tr>
                    
                    <tr class="total">
                        <td colspan="2">JUMLAH BERAT</td>
                        @foreach ($result['harga'] as $i => $hrg)
                            @php $beratSedia = $result['total_sedia'][$i] * $hrg->berat; $hasilKedelai += $beratSedia; @endphp
                            <td>{{ $beratSedia }}</td>
                        @endforeach
                        @foreach ($result['harga'] as $i => $hrg)
                            <td></td>
                        @endforeach
                    </tr>
                    
                    <tr class="total">
                        <td colspan="2">HASIL KEDELAI</td>
                        <td colspan="{{ $hargaCount * 2 }}">{{ $hasilKedelai }}</td>
                    </tr>
                    
                    <tr class="total">
                        <td colspan="2">RENDAMAN</td>
                        <td colspan="{{ $hargaCount * 2 }}">{{ $result['rendaman'] }}</td>
                    </tr>
                    
                    <tr class="total">
                        <td colspan="2">KEMEKARAN</td>
                        <td colspan="{{ $hargaCount * 2 }}">
                            {{ $result['rendaman'] != 0 ? round($hasilKedelai / $result['rendaman'], 8) : '' }}
                        </td>
                    </tr>
                    
                    @if ($isAdmin)
                        <tr class="total">
                            <td colspan="2">SELISIH</td>
                            @foreach ($result['harga'] as $i => $hrg)
                                <td>{{ $result['total_sedia'][$i] - $result['hasil'][$i] }}</td>
                            @endforeach
                            @foreach ($result['harga'] as $i => $hrg)
                                <td></td>
                            @endforeach
                        </tr>
                        
                        <tr class="total">
                            <td colspan="2">HASIL PRODUKSI</td>
                            @foreach ($result['harga'] as $i => $hrg)
                                <td>{{ $result['hasil'][$i] }}</td>
                            @endforeach
                            @foreach ($result['harga'] as $i => $hrg)
                                <td></td>
                            @endforeach
                        </tr>
                        
                        <tr class="total">
                            <td colspan="2">HASIL KOTOR</td>
                            @foreach ($result['hasil_kotor']['sedia'] as $hk)
                                <td>{{ number_format($hk, 0, '', '.') }}</td>
                            @endforeach
                            @foreach ($result['hasil_kotor']['laku'] as $hk)
                                <td>{{ number_format($hk, 0, '', '.') }}</td>
                            @endforeach
                        </tr>
                        
                        @php
                            $sediaTotal = array_sum($result['hasil_kotor']['sedia']);
                            $lakuTotal = array_sum($result['hasil_kotor']['laku']);
                            $kerugianHariIni = $sediaTotal - $lakuTotal;
                            $totalKerugianBulan += $kerugianHariIni; // Add daily loss to monthly total
                            $totalSediaBulan += $sediaTotal; // Add daily sedia to monthly total
                            $totalLakuBulan += $lakuTotal; // Add daily laku to monthly total
                        @endphp
                        
                        <tr class="total">
                            <td colspan="2">TOTAL</td>
                            <td colspan="{{ $hargaCount }}">{{ number_format($sediaTotal, 0, '', '.') }}</td>
                            <td colspan="{{ $hargaCount }}">{{ number_format($lakuTotal, 0, '', '.') }}</td>
                        </tr>

                        {{-- Show monthly total only on the last page --}}
                        @if ($resultIndex === count($results) - 1)
                            <tr class="total" style="background-color:#e8f5e9;border-top:2px solid #179419ff">
                                <td colspan="2">TOTAL BULAN INI</td>
                                <td colspan="{{ $hargaCount }}">{{ number_format($totalSediaBulan, 0, '', '.') }}</td>
                                <td colspan="{{ $hargaCount }}">{{ number_format($totalLakuBulan, 0, '', '.') }}</td>
                            </tr>
                        @endif
                        
                        <tr class="total">
                            <td colspan="2">TOTAL KERUGIAN HARI INI</td>
                            <td colspan="{{ $hargaCount * 2 }}">{{ number_format($kerugianHariIni, 0, '', '.') }}</td>
                        </tr>
                        
                        {{-- Show monthly total only on the last page --}}
                        @if ($resultIndex === count($results) - 1)
                            <tr class="total" style="background-color:#ffebee;border-top:2px solid #d32f2f">
                                <td colspan="2">TOTAL KERUGIAN BULAN INI</td>
                                <td colspan="{{ $hargaCount * 2 }}">{{ number_format($totalKerugianBulan, 0, '', '.') }}</td>
                            </tr>
                        @endif
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    
    @if (!$isAdmin)
        <div class="spacer"></div>
    @endif
@endforeach

<script>
    // Auto print when page loads
    window.addEventListener('load', function() {
        // Set document title for filename when saving
        const fromDate = '{{ request("from") }}';
        const toDate = '{{ request("to") }}';
        
        if (fromDate && toDate) {
            document.title = `Monitoring_${fromDate}_${toDate}`;
        } else {
            // Fallback if dates not available
            const currentDate = new Date().toISOString().split('T')[0];
            document.title = `Monitoring_${currentDate}`;
        }
        
        // Small delay to ensure content is fully rendered
        setTimeout(function() {
            window.print();
            
            // Set multiple timeouts to handle different scenarios
            // Close after print dialog is dismissed (short delay for cancel)
            setTimeout(function() {
                window.close();
            }, 1000);
            
            // Backup close for longer operations (save PDF)
            setTimeout(function() {
                window.close();
            }, 5000);
        }, 500);
    });
    
    // Close after printing is complete
    window.addEventListener('afterprint', function() {
        setTimeout(function() {
            window.close();
        }, 100);
    });
    
    // Close window when user navigates away or closes print dialog
    window.addEventListener('beforeunload', function() {
        // This runs when page is about to unload
    });
    
    // Additional methods to ensure closure
    document.addEventListener('keydown', function(e) {
        // Close on Escape key (common for cancel)
        if (e.key === 'Escape') {
            setTimeout(function() {
                window.close();
            }, 500);
        }
    });
    
    // Focus events to detect when print dialog closes
    window.addEventListener('focus', function() {
        // When window regains focus (print dialog closed)
        setTimeout(function() {
            window.close();
        }, 1000);
    });
</script>

</body>

</html>
