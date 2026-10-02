<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">
    
    <!-- Title Page-->
    <title>Tempe Dangsul</title>
    
    <!-- Icons font CSS-->
    <link href="{{ asset('front/vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('front/vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Vendor CSS-->
    <link href="{{ asset('front/vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <!-- <link href="{{ asset('front/vendor/datepicker/daterangepicker.css') }}" rel="stylesheet" media="all"> -->
    
    <!-- Main CSS-->
    <link href="{{ asset('front/css/main.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('front/css/custom.css') }}" rel="stylesheet" media="all">
    
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.standalone.min.css">
    
    
</head>

<body>
    <div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins" style="border-radius: 0px; !important">
        <div class="wrapper wrapper--w680" >
            <div class="card card-4">
                <div class="navbar">
                    <a href="{{ route('sales.home') }}">Laporan</a>
                    <a href="#news">Data Laporan</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <div class="card-body">
                    @if ($message = Session::get('sisa'))
                    <div class="alert">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span> 
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    
                    <h3><strong>Laporan Sales</strong></h3>
                    <h3>Nama : {{ Auth::user()->name }}</h3>
                    <br><br>
                    <form method="POST" action="{{ route('sales.sisa') }}">
                        @csrf
                        <h4><strong>MASUKKAN SISA MUDA :</strong></h4><br>
                        @for ($i = 0; $i < count($harga); $i++)
                        <div class="input-group">
                            @if ($sisa[$i] == 0)
                            <input class="input--style-4" type="hidden" name="sisa_muda[{{$i}}]" value="0">
                            @else
                            <label class="label">{{ $harga[$i] }} ( TOTAL SISA : {{ $sisa[$i] }} )</label>
                            <input class="input--style-4" type="number" name="sisa_muda[{{$i}}]" min="0" max="{{ $sisa[$i] }}" required>
                            @endif
                            <input type="hidden" name="harga[]" value="{{ $harga[$i] }}">
                            <input type="hidden" name="bawa[]" value="{{ $bawa[$i] }}">
                            <input type="hidden" name="laku[]" value="{{ $laku[$i] }}">
                            <input type="hidden" name="sisa[]" value="{{ $sisa[$i] }}">
                            <input type="hidden" name="jumlah[]" value="{{ $jumlah[$i] }}">
                        </div>
                        @endfor
                        
                        <input type="hidden" name="hutang_baru" value="{{ $hutang_baru }}">
                        <input type="hidden" name="pelunasan" value="{{ $pelunasan }}">
                        <input type="hidden" name="tgl_laporan" value="{{ $tgl_laporan }}">
                        
                        
                        <div class="p-t-15 tengah"> 
                            <button class="btn btn--radius-2 btn--blue" type="submit" style="width: 100% !important;">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Jquery JS-->
    <script src="{{ asset('front/vendor/jquery/jquery.min.js') }}"></script>
    <!-- Vendor JS-->
    <script src="{{ asset('front/vendor/select2/select2.min.js') }}"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    
    <!-- Main JS-->
    <script src="{{ asset('front/js/global.js') }}"></script>
    
    <script type="text/javascript">
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });
    </script>
    
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->