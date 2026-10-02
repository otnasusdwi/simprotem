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
                                        <h5 class="m-b-10">Monitoring</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#"><i class="feather icon-home"></i></a>
                                        </li>
                                        <li class="breadcrumb-item"><a href="javascript:">Data Monitoring</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- The Modal -->
                    <div class="modal fade" id="modalSync" data-keyboard="false" data-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal body -->
                                <div class="modal-body text-center">
                                    <h4><strong>Harap tunggu</strong></h4>
                                    <h5>Proses singkronisasi sedang berlangsung</h5>
                                    <br />
                                    <img src="{{ asset('loading.gif') }}" alt="loading">
                                    <br />
                                    <br />
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
                                                    <h5>Tanggal Laporan : {{ $tgl }}</h5>
                                                    {{-- <a href="{{ route('admin.edit_monitoring', $id_monitoring) }}" title="" class="btn theme-bg" style="color: white;">Edit</a> --}}
                                                </div>

                                                <div class="col-xl-6 col-md-6" style="text-align: right;">
                                                    <div class="dropdown">
                                                        {{-- <button onClick="window.location.reload();" class="btn theme-bg"
													style="color: white;" >Sinkronisasi</button> --}}
                                                        <button class="theme-bg btn btn-secondary dropdown-toggle"
                                                            type="button" id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            Aksi
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <form method="POST" action="{{ route('admin.sinkronisasi') }}"
                                                                name="sync">
                                                                @csrf
                                                                <input type="hidden" name="tgl_laporan"
                                                                    value="{{ $tgl_laporan }}">
                                                                <input type="hidden" name="id_monitoring"
                                                                    value="{{ $id_monitoring }}">
                                                                @for ($i = 0; $i < count($sales); $i++)
                                                                    <input type="hidden"
                                                                        name="users[{{ $i }}][id]"
                                                                        value="{{ $sales[$i]->id }}">
                                                                    <input type="hidden"
                                                                        name="users[{{ $i }}][tipe]"
                                                                        value="{{ $sales[$i]->tipe }}">
                                                                @endfor
                                                                @for ($i = 0; $i < count($harga); $i++)
                                                                    <input type="hidden" name="harga[]"
                                                                        value="{{ $harga[$i]->harga }}">
                                                                @endfor
                                                                <button type="submit" id="sync" class="dropdown-item"
                                                                    onclick="openModalSync()"><b>Sinkronisasi</b></button>
                                                            </form>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.edit_monitoring', $id_monitoring) }}">Sedia</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.tambah_monitoring', $id_monitoring) }}">Tambah</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.sisa_monitoring', $id_monitoring) }}">Sisa</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.create_rendaman', $id_monitoring) }}">Redaman</a>
                                                            <a class="dropdown-item"
                                                                href="{{ route('admin.hasil_monitoring', $id_monitoring) }}">Hasil
                                                                Produksi</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="card-block px-0 py-3">
                                            <div class="table-responsive">
                                                <table class="table table-hover text-center" id="">
                                                    <thead>
                                                        <tr class="unread">
                                                            <th rowspan="2" style="vertical-align: middle;">
                                                                <h6 class="mb-1"><b>NO</b></h6>
                                                            </th>
                                                            <th rowspan="2" style="vertical-align: middle;">
                                                                <h6 class="mb-1"><b>SALES</b></h6>
                                                            </th>
                                                            <th colspan="{{ count($harga) + 1 }}">
                                                                <h6 class="mb-1"><b>SEDIA</b></h6>
                                                            </th>
                                                            {{-- <th colspan="{{ count($harga) + 1 }}">
                                                                <h6 class="mb-1"><b>LAKU</b></h6>
                                                            </th>
                                                            <th colspan="{{ count($harga) + 1 }}">
                                                                <h6 class="mb-1"><b>TAMBAH<br>( sales | admin )</b></h6>
                                                            </th>
                                                            <th colspan="{{ count($harga) + 1 }}">
                                                                <h6 class="mb-1"><b>SISA MUDA<br>( sales | admin )</b>
                                                                </h6>
                                                            </th>
                                                            <th colspan="{{ count($harga) + 1 }}">
                                                                <h6 class="mb-1"><b>SISA TUA<br>( sales | admin )</b>
                                                                </h6>
                                                            </th> --}}
                                                        </tr>
                                                        <tr class="unread">
                                                            @foreach ($harga as $hrg)
                                                                <th>
                                                                    <h6 class="mb-1"><b>{{ $hrg->harga }}</b></h6><br>
                                                                    {{ $hrg->berat }}
                                                                </th>
                                                            @endforeach
                                                            {{-- <th style="background-color: #3e4c66;"></th>
                                                            @foreach ($harga as $hrg)
                                                                <th>
                                                                    <h6 class="mb-1"><b>{{ $hrg->harga }}</b></h6>
                                                                    <br><br>
                                                                </th>
                                                            @endforeach
                                                            <th style="background-color: #3e4c66;"></th>
                                                            @foreach ($harga as $hrg)
                                                                <th>
                                                                    <h6 class="mb-1"><b>{{ $hrg->harga }}</b></h6>
                                                                    <br><br>
                                                                </th>
                                                            @endforeach
                                                            <th style="background-color: #3e4c66;"></th>
                                                            @foreach ($harga as $hrg)
                                                                <th>
                                                                    <h6 class="mb-1"><b>{{ $hrg->harga }}</b></h6>
                                                                    <br><br>
                                                                </th>
                                                            @endforeach
                                                            <th style="background-color: #3e4c66;"></th>
                                                            @foreach ($harga as $hrg)
                                                                <th>
                                                                    <h6 class="mb-1"><b>{{ $hrg->harga }}</b></h6>
                                                                    <br><br>
                                                                </th>
                                                            @endforeach --}}
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @for ($i = 0; $i < count($sales); $i++)
                                                            <tr>
                                                                <td>
                                                                    <h6 class="mb-1">{{ $i + 1 }}</h6>
                                                                </td>
                                                                <td>
                                                                    <h6 class="mb-1">{{ $sales[$i]->name }}</h6>
                                                                </td>
                                                                @foreach ($harga as $hrg)
                                                                    <td>
                                                                        <h6 class="mb-1">
                                                                            @foreach ($data as $row)
                                                                                @if ($row->id_user == $sales[$i]->id && $row->harga == $hrg->harga)
                                                                                    {{ $row->sedia }}
                                                                                @endif
                                                                            @endforeach
                                                                        </h6>
                                                                    </td>
                                                                @endforeach
                                                                {{-- <td style="background-color: #3e4c66;"></td>
                                                                @foreach ($harga as $hrg)
                                                                    <td>
                                                                        <h6 class="mb-1">
                                                                            @foreach ($data as $row)
                                                                                @if ($row->id_user == $sales[$i]->id && $row->harga == $hrg->harga)
                                                                                    {{ $row->laku }}
                                                                                @endif
                                                                            @endforeach
                                                                        </h6>
                                                                    </td>
                                                                @endforeach
                                                                <td style="background-color: #3e4c66;"></td>
                                                                @foreach ($harga as $hrg)
                                                                    <td>
                                                                        <h6 class="mb-1">
                                                                            @foreach ($data as $row)
                                                                                @if ($row->id_user == $sales[$i]->id && $row->harga == $hrg->harga)
                                                                                    {{ $row->tambah_sales }}|
                                                                                    <b>{{ $row->tambah }} </b>
                                                                                @endif
                                                                            @endforeach
                                                                        </h6>
                                                                    </td>
                                                                @endforeach
                                                                <td style="background-color: #3e4c66;"></td>
                                                                @foreach ($harga as $hrg)
                                                                    <td>
                                                                        <h6 class="mb-1">
                                                                            @foreach ($data as $row)
                                                                                @if ($row->id_user == $sales[$i]->id && $row->harga == $hrg->harga)
                                                                                    {{ $row->sisa_muda }} | <b>
                                                                                        {{ $row->muda }} </b>
                                                                                @endif
                                                                            @endforeach
                                                                        </h6>
                                                                    </td>
                                                                @endforeach
                                                                <td style="background-color: #3e4c66;"></td>
                                                                @foreach ($harga as $hrg)
                                                                    <td>
                                                                        <h6 class="mb-1">
                                                                            @foreach ($data as $row)
                                                                                @if ($row->id_user == $sales[$i]->id && $row->harga == $hrg->harga)
                                                                                    {{ $row->sisa_tua }} | <b>
                                                                                        {{ $row->tua }} </b>
                                                                                @endif
                                                                            @endforeach
                                                                        </h6>
                                                                    </td>
                                                                @endforeach
                                                            </tr> --}}
                                                        @endfor
                                                        <tr>
                                                            <td colspan="2">
                                                                <h6><b>JUMLAH TOTAL</b></h6>
                                                            </td>

                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">
                                                                        <b>{{ $total_sedia[$i] }}</b>
                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            {{-- <td style="background-color: #3e4c66;"></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">
                                                                        <b>{{ $total_laku[$i] }}</b>
                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td style="background-color: #3e4c66;"></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">
                                                                        <b>{{ $total_tambah[$i] }}</b>
                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td style="background-color: #3e4c66;"></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">
                                                                        <b>{{ $total_sisa_muda[$i] }} |
                                                                            {{ $total_muda[$i] }}</b>
                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td style="background-color: #3e4c66;"></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">
                                                                        <b>{{ $total_sisa_tua[$i] }} |
                                                                            {{ $total_tua[$i] }}</b>
                                                                    </h6>
                                                                </td>
                                                            @endforeach --}}
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <h6><b>JUMLAH BERAT</b></h6>
                                                            </td>
                                                            @php
                                                                $hasil_kedelai = 0;
                                                            @endphp
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">
                                                                        <b>{{ $total_sedia[$i] * $hrg->berat }}</b>
                                                                        @php
                                                                            $hasil_kedelai = $hasil_kedelai + $total_sedia[$i] * $hrg->berat;
                                                                        @endphp
                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            {{-- <td style="background-color: #3e4c66;"></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td style="background-color: #3e4c66;"></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td style="background-color: #3e4c66;"></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td style="background-color: #3e4c66;"></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach --}}
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <h6><b>HASIL KEDELAI</b></h6>
                                                            </td>
                                                            <td colspan="4">
                                                                <h6><b>{{ $hasil_kedelai }}</b></h6>
                                                            </td>
                                                            {{-- @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach --}}
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <h6><b>RENDAMAN</b></h6>
                                                            </td>
                                                            <td colspan="4">
                                                                <h6><b>{{ $rendaman }}</b></h6>
                                                            </td>
                                                            {{-- @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach --}}
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <h6><b>KEMEKARAN</b></h6>
                                                            </td>
                                                            <td colspan="4">
                                                                <h6>
                                                                    <b>
                                                                        @if ($rendaman != 0)
                                                                            {{ $hasil_kedelai / $rendaman }}
                                                                        @endif
                                                                    </b>
                                                                </h6>
                                                            </td>
                                                            {{-- @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach --}}
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">
                                                                <h6><b>SELISIH</b></h6>
                                                            </td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">
                                                                        <b>{{ $total_sedia[$i] - $hasil[$i] }}</b>
                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            {{-- <td style="background-color: #3e4c66;"></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td style="background-color: #3e4c66;"></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">
                                                                        <b>{{ $total_tambah[$i] - $total_tambah_sales[$i] }}</b>
                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td style="background-color: #3e4c66;"></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">
                                                                        <b>{{ $total_sisa_muda[$i] - $total_muda[$i] }}</b>
                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td style="background-color: #3e4c66;"></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">
                                                                        <b>{{ $total_sisa_tua[$i] - $total_tua[$i] }}</b>
                                                                    </h6>
                                                                </td>
                                                            @endforeach --}}
                                                        </tr>

                                                        <tr>
                                                            <td colspan="2">
                                                                <h6><b>HASIL PRODUKSI</b></h6>
                                                            </td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">
                                                                        <b>{{ $hasil[$i] }}</b>
                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            {{-- <td style="background-color: #3e4c66;"></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td style="background-color: #3e4c66;"></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td style="background-color: #3e4c66;"></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach
                                                            <td style="background-color: #3e4c66;"></td>
                                                            @foreach ($harga as $i => $hrg)
                                                                <td>
                                                                    <h6 class="mb-1">

                                                                    </h6>
                                                                </td>
                                                            @endforeach --}}
                                                        </tr>
                                                        @if (Auth::user()->level == 3)
                                                            <tr>
                                                                <td colspan="2">
                                                                    <h6><b>HASIL KOTOR</b></h6>
                                                                </td>
                                                                @foreach ($hasil_kotor['sedia'] as $i => $hk)
                                                                    <td>
                                                                        <h6 class="mb-1">
                                                                            <b>{{ number_format($hk, 0, '', '.') }}</b>
                                                                        </h6>
                                                                    </td>
                                                                @endforeach
                                                                {{-- <td style="background-color: #3e4c66;"></td>
                                                                @foreach ($hasil_kotor['laku'] as $i => $hk)
                                                                    <td>
                                                                        <h6 class="mb-1">
                                                                            <b>{{ number_format($hk, 0, '', '.') }}</b>
                                                                        </h6>
                                                                    </td>
                                                                @endforeach
                                                                @foreach ($harga as $i => $hrg)
                                                                    <td>
                                                                        <h6 class="mb-1">
                                                                            <b>{{ number_format($hk, 0, '', '.') }}</b>
                                                                        </h6>
                                                                    </td>
                                                                @endforeach --}}
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <h6><b>TOTAL</b></h6>
                                                                </td>
                                                                @php
                                                                    $sediaTotal = 0;
                                                                @endphp
                                                                @foreach ($hasil_kotor['sedia'] as $i => $hk)
                                                                    @php $sediaTotal += $hk @endphp
                                                                @endforeach
                                                                <td colspan="{{ count($harga) }}">
                                                                    <h6 class="mb-1">
                                                                        <b>{{ number_format($sediaTotal, 0, '', '.') }}</b>
                                                                    </h6>
                                                                </td>
                                                                {{-- <td style="background-color: #3e4c66;"></td>
                                                                @php
                                                                    $sediaTotal = 0;
                                                                @endphp
                                                                @foreach ($hasil_kotor['laku'] as $i => $hk)
                                                                    @php $sediaTotal += $hk @endphp
                                                                @endforeach
                                                                <td colspan="{{ count($harga) }}">
                                                                    <h6 class="mb-1">
                                                                        <b>{{ number_format($sediaTotal, 0, '', '.') }}</b>
                                                                    </h6>
                                                                </td>
                                                                <td style="background-color: #3e4c66;"></td>
                                                                @foreach ($harga as $i => $hrg)
                                                                    <td>
                                                                        <h6 class="mb-1">

                                                                        </h6>
                                                                    </td>
                                                                @endforeach
                                                                <td style="background-color: #3e4c66;"></td>
                                                                @foreach ($harga as $i => $hrg)
                                                                    <td>
                                                                        <h6 class="mb-1">

                                                                        </h6>
                                                                    </td>
                                                                @endforeach
                                                                <td style="background-color: #3e4c66;"></td>
                                                                @foreach ($harga as $i => $hrg)
                                                                    <td>
                                                                        <h6 class="mb-1">

                                                                        </h6>
                                                                    </td>
                                                                @endforeach --}}
                                                            </tr>
                                                        @endif
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
@endsection
@section('script')
    @if ($status == 0)
        <script>
            $('#modalSync').modal('show');

            $(document).ready(function() {
                $("#sync").trigger('click');
            });
        </script>
    @endif
    <script>
        history.pushState(null, document.title, location.href);
        history.back();
        history.forward();
        window.onpopstate = function() {
            history.go(1);
        };

        function openModalSync() {
            $('#modalSync').modal('show');
        }
    </script>
@endsection
