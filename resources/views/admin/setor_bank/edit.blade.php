@extends('../layouts.app')
@section('content')
    <style>
        /* Hide up and down arrows for numeric inputs */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
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
                                        <h5 class="m-b-10">Debit Kredit</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="javascript:">Input Data Debit Kredit</a></li>
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
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header">
                                            @if ($get->bulan && $get->tahun)
                                                <h5>{{ Carbon\Carbon::parse($get->tahun . '-' . $get->bulan . '-01')->translatedFormat('F Y') }}</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            @if ($message = Session::get('warning'))
                                                <div class="alert alert-warning alert-block">
                                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @endif
                                            <form method="POST" action="{{ route('admin.update_setor_bank') }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="bulan" value="{{ $get->bulan }}">
                                                <input type="hidden" name="tahun" value="{{ $get->tahun }}">
                                                <input type="hidden" name="rows" id="row-count" value="0">
                                                <div class="table-responsive">
                                                    <table class="table table-borderless align-middle" id="dynamic-table">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:10%; text-align: center;">Tanggal</th>
                                                                <th style="width:45%; text-align: right;">Uang Masuk</th>
                                                                <th style="width:45%; text-align: right;">Uang Keluar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="dynamic-form-rows">
                                                            {{-- Baris akan di-generate oleh JS --}}
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="d-flex gap-2 mb-3">
                                                    <button type="submit" class="btn btn-primary"><i
                                                            class="feather icon-save"></i> Update</button>
                                                </div>
                                            </form>
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    function daysInMonth(month, year) {
                                                        return new Date(year, month, 0).getDate();
                                                    }

                                                    function pad(num) {
                                                        return num.toString().padStart(2, '0');
                                                    }

                                                    function getDataByDate(date) {
                                                        // Cari data yang tanggalnya sama dengan date
                                                        @php
                                                            $dataArr = [];
                                                            foreach($data as $item) {
                                                                $dataArr[$item->tgl_setor] = [
                                                                    'uang_masuk' => $item->uang_masuk,
                                                                    'pengeluaran' => $item->pengeluaran
                                                                ];
                                                            }
                                                        @endphp
                                                        const dataMap = @json($dataArr);
                                                        return dataMap[date] || {uang_masuk: '', pengeluaran: ''};
                                                    }

                                                    function generateRows() {
                                                        const bulan = "{{ $get->bulan }}";
                                                        const tahun = "{{ $get->tahun }}";
                                                        if (!bulan || !tahun) return;

                                                        const rowContainer = document.getElementById('dynamic-form-rows');
                                                        rowContainer.innerHTML = '';
                                                        const totalDays = daysInMonth(parseInt(bulan), parseInt(tahun));
                                                        document.getElementById('row-count').value = totalDays;

                                                        for (let i = 1; i <= totalDays; i++) {
                                                            const tgl = tahun + '-' + pad(bulan) + '-' + pad(i);
                                                            const data = getDataByDate(tgl);
                                                            const tr = document.createElement('tr');
                                                            tr.className = 'dynamic-row';
                                                            tr.innerHTML = `
                                                                <td style="text-align: center;">
                                                                    <input type="text" class="form-control form-control-sm" name="tgl_setor[]" value="${tgl}" readonly style="display: none;">
                                                                    <span>${i}</span>
                                                                </td>
                                                                <td>
                                                                    <input type="number" step="0.01" min="0"
                                                                        class="form-control form-control-sm text-right uang-masuk"
                                                                        placeholder="Uang Masuk" name="uang_masuk[]" value="${data.uang_masuk}">
                                                                </td>
                                                                <td>
                                                                    <input type="number" step="0.01" min="0"
                                                                        class="form-control form-control-sm text-right pengeluaran-input"
                                                                        placeholder="Pengeluaran" name="pengeluaran[]" value="${data.pengeluaran}">
                                                                </td>
                                                            `;
                                                            rowContainer.appendChild(tr);
                                                        }
                                                    }

                                                    generateRows();
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
