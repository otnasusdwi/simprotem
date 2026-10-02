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
																		  <span style=" color: green;text-align: center;"">
                                                            <strong>LUNAS</strong> ( {{ $acc }} )
                                                        </span>
                                                        @endif
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{ route('admin.update') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id_laporan" value="{{ $id_laporan }}">
                                            <input type="hidden" name="tgl_laporan" value="{{ $tgl }}">
                                            <input type="hidden" name="id_user" value="{{ $user->id }}">
                                            <div class="card-block px-0 py-3">
                                                <div class="table-responsive">
                                                    <table class="table table-hover text-center">
                                                        <thead>
                                                            <tr class="unread">
                                                                <th>
                                                                    <h6 class="mb-1"><b>HARGA</b></h6>
                                                                </th>
                                                                <th>
                                                                    <h6 class="mb-1"><b>SEDIA</b></h6>
                                                                </th>
                                                                <th>
                                                                    <h6 class="mb-1"><b>BAWA</b></h6>
                                                                </th>
                                                                <th>
                                                                    <h6 class="mb-1"><b>TAMBAH</b></h6>
                                                                </th>
                                                                <th>
                                                                    <h6 class="mb-1"><b>SISA MUDA</b></h6>
                                                                </th>
                                                                <th>
                                                                    <h6 class="mb-1"><b>SISA TUA</b></h6>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach($data as $index => $row)
                                                            <tr>
                                                                <td style="color: black; font-weight: bold;">
                                                                    {{ number_format($row->harga,0,',','.') }}
                                                                    <input type="hidden" name="harga[{{ $index }}]"
                                                                        value="{{ $row->harga }}">
                                                                </td>
                                                                {{-- <td> = </td> --}}
                                                                <td style="color: black; font-weight: bold;">
                                                                    {{ $sedia[$index] }}
                                                                    <input type="hidden" name="sedia[{{ $index }}]"
                                                                        value="{{ $sedia[$index] }}">
                                                                </td>
                                                                <td style="color: black; font-weight: bold;">
                                                                    {{-- {{ $row->bawa }} --}}
                                                                    <input type="number" class="form-control"
                                                                        placeholder="" name="bawa[{{ $index }}]" min="0"
                                                                        required value="{{ $row->bawa }}">
                                                                </td>
                                                                <td style="color: black; font-weight: bold;">
                                                                    {{-- {{ $tambah[$index] }} --}}
                                                                    <input type="number" class="form-control"
                                                                        placeholder="" name="tambah[{{ $index }}]"
                                                                        min="0" required value="{{ $tambah[$index] }}">
                                                                </td>
                                                                <td style="color: black; font-weight: bold;">
                                                                    {{-- {{ $row->sisa_muda }} --}}
                                                                    <input type="number" class="form-control"
                                                                        placeholder="" name="sisa_muda[{{ $index }}]"
                                                                        min="0" required value="{{ $row->sisa_muda }}">
                                                                </td>
                                                                <td style="color: black; font-weight: bold;">
                                                                    {{-- {{ $row->sisa_tua }} --}}
                                                                    <input type="number" class="form-control"
                                                                        placeholder="" name="sisa_tua[{{ $index }}]"
                                                                        min="0" required value="{{ $row->sisa_tua }}">
                                                                </td>
                                                            </tr>

                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <br><br>

                                                <div class="table-responsive">
                                                    <table class="table table-hover text-center"
                                                        style="color: black; font-weight: bold;">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="2" class="text-center">
                                                                    <h6 class="mb-1">
                                                                        <b>PIUTANG ( Rp
                                                                            {{-- {{ number_format(($user->piutang),0,',','.') }},- --}}
                                                                            {{ number_format(($user->piutang - $row->hutang_baru + $row->pelunasan),0,',','.') }},-
                                                                           
                                                                            )
                                                                        </b>
                                                                    </h6>
                                                                    {{-- <input type="hidden" name="piutang"
                                                                        value="{{ $user->piutang }}"> --}}
                                                                    <input type="hidden" name="piutang"
                                                                        value="{{ $user->piutang - $row->hutang_baru + $row->pelunasan }}">
                                                                   
                                                                    <input type="hidden" name="id_user"
                                                                        value="{{ $user->id }}">
                                                                    <input type="hidden" name="tipe"
                                                                        value="{{ $user->tipe }}">
                                                                </th>
                                                                {{-- <th rowspan="2" class="text-center"
                                                                style="vertical-align: middle;">
                                                                <h6 class="mb-1"><b>TOTAL HUTANG</b></h6>
                                                            </th> --}}
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
                                                                    {{-- Rp
                                                                    {{ number_format($row->hutang_baru,0,',','.') }},-
                                                                    --}}
                                                                    <input type="number" class="form-control"
                                                                        placeholder="" name="hutang_baru" min="0"
                                                                        required value="{{ $row->hutang_baru }}">
                                                                </td>
                                                                <td>
                                                                    {{-- Rp {{ number_format($row->pelunasan,0,',','.') }},-
                                                                    --}}
                                                                    <input type="number" class="form-control"
                                                                        placeholder="" name="pelunasan" min="0" required
                                                                        value="{{ $row->pelunasan }}">
                                                                </td>
                                                                {{-- <td>
                                                                Rp {{ number_format($row->piutang,0,',','.') }},-
                                                                </td> --}}
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div class="text-center">
                                                        <button type="submit" class="btn theme-bg"
                                                            style="color: white; width: 250px;"><b>UPDATE</b></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
