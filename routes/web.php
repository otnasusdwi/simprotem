<?php

use App\Http\Controllers\LogSyncMonitoringController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;



// use Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    if (Auth::user()) {
        if (Auth::user()->role == 'admin') {
            return redirect('admin/home');
        } else {
            return redirect('sales/home');
        }
    } else {
        return view('auth.login');
    }
});

Auth::routes(['register' => false]);

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

// Route::get('/home', 'AdminHomeController@index')->name('home')->middleware('is_admin');

Route::prefix('admin')->group(function () {
    Route::get('/home', 'AdminHomeController@index')->name('admin.home')->middleware('is_admin');
    Route::get('/detail/{id_laporan}', 'AdminHomeController@detail')->name('admin.detail')->middleware('is_admin');
    Route::get('/edit/{id_laporan}', 'AdminHomeController@edit')->name('admin.edit')->middleware('is_admin');
    Route::post('/update', 'AdminHomeController@update')->name('admin.update')->middleware('is_admin');
    // Route::get('/edit/{id_item_laporan}', 'AdminHomeController@edit')->name('admin.edit')->middleware('is_admin');
    Route::patch('/status/{id_laporan}', 'AdminHomeController@status')->name('admin.status')->middleware('is_admin');
    Route::delete('/hapus/{id_laporan}', 'AdminHomeController@hapus')->name('admin.hapus')->middleware('is_admin');
    Route::post('/postcetak', 'AdminHomeController@postCetak')->name('admin.postcetak')->middleware('is_admin');
    Route::get('/cetak', 'AdminHomeController@cetakExcel')->name('admin.cetak')->middleware('is_admin');
    Route::get('/cetakpdf', 'AdminHomeController@cetakPDF')->name('admin.cetakpdf')->middleware('is_admin');
    Route::get('/pdf', 'AdminHomeController@pdf')->name('admin.pdf')->middleware('is_admin');
    Route::get('/pdf-kasir', 'AdminHomeController@pdfKasir')->name('admin.pdf-kasir')->middleware('is_admin');
    Route::get('/detail_setoran/', 'AdminHomeController@detailSetoran')->name('admin.detail_setoran')->middleware('is_admin');
    Route::get('/getsales/{id_tipe}', 'AdminHomeController@getSales')->name('getSales')->middleware('is_admin');

    Route::post('/filter', 'AdminHomeController@filter')->name('admin.filter')->middleware('is_sales');

    Route::get('/tipe', 'AdminTipeController@index')->name('admin.tipe')->middleware('is_admin');
    Route::get('/create_tipe', 'AdminTipeController@create')->name('admin.create_tipe')->middleware('is_admin');
    Route::post('/store_tipe', 'AdminTipeController@store')->name('admin.store_tipe')->middleware('is_admin');
    Route::get('/edit_tipe/{id_tipe}', 'AdminTipeController@edit')->name('admin.edit_tipe')->middleware('is_admin');
    Route::post('/update_tipe', 'AdminTipeController@update')->name('admin.update_tipe')->middleware('is_admin');
    Route::get('/delete_tipe/{id_tipe}', 'AdminTipeController@delete')->name('admin.delete_tipe')->middleware('is_admin');

    Route::get('/delete_user/{id}', 'AdminUserController@delete')->name('admin.delete_user')->middleware('is_admin');

    Route::get('/sales', 'AdminUserController@sales')->name('admin.sales')->middleware('is_admin');
    Route::get('/create_sales', 'AdminUserController@createsales')->name('admin.create_sales')->middleware('is_admin');
    Route::post('/store_sales', 'AdminUserController@storesales')->name('admin.store_sales')->middleware('is_admin');
    Route::get('/edit_sales/{id}', 'AdminUserController@editsales')->name('admin.edit_sales')->middleware('is_admin');
    Route::post('/update_sales', 'AdminUserController@updatesales')->name('admin.update_sales')->middleware('is_admin');

    Route::get('/reset_password/{id}', 'AdminUserController@resetpassword')->name('admin.reset_password')->middleware('is_admin');
    Route::post('/update_password', 'AdminUserController@updatepassword')->name('admin.update_password')->middleware('is_admin');

    Route::get('/karyawan', 'AdminKaryawanController@index')->name('admin.karyawan')->middleware('is_admin');
    Route::get('/create_karyawan', 'AdminKaryawanController@create')->name('admin.create_karyawan')->middleware('is_admin');
    Route::post('/store_karyawan', 'AdminKaryawanController@store')->name('admin.store_karyawan')->middleware('is_admin');
    Route::get('/edit_karyawan/{id}', 'AdminKaryawanController@edit')->name('admin.edit_karyawan')->middleware('is_admin');
    Route::post('/update_karyawan', 'AdminKaryawanController@update')->name('admin.update_karyawan')->middleware('is_admin');
    Route::get('/delete_karyawan/{id}', 'AdminKaryawanController@delete')->name('admin.delete_karyawan')->middleware('is_admin');

    Route::get('/pelanggan', 'AdminPelangganController@index')->name('admin.pelanggan')->middleware('is_admin');
    Route::get('/create_pelanggan', 'AdminPelangganController@create')->name('admin.create_pelanggan')->middleware('is_admin');
    Route::post('/store_pelanggan', 'AdminPelangganController@store')->name('admin.store_pelanggan')->middleware('is_admin');
    Route::get('/edit_pelanggan/{id}', 'AdminPelangganController@edit')->name('admin.edit_pelanggan')->middleware('is_admin');
    Route::post('/update_pelanggan', 'AdminPelangganController@update')->name('admin.update_pelanggan')->middleware('is_admin');
    Route::get('/delete_pelanggan/{id}', 'AdminPelangganController@delete')->name('admin.delete_pelanggan')->middleware('is_admin');

    Route::get('/admin', 'AdminUserController@admin')->name('admin.admin')->middleware('is_admin');
    Route::get('/create_admin', 'AdminUserController@createadmin')->name('admin.create_admin')->middleware('is_admin');
    Route::post('/store_admin', 'AdminUserController@storeadmin')->name('admin.store_admin')->middleware('is_admin');
    Route::get('/edit_admin/{id}', 'AdminUserController@editadmin')->name('admin.edit_admin')->middleware('is_admin');
    Route::post('/update_admin', 'AdminUserController@updateadmin')->name('admin.update_admin')->middleware('is_admin');

    // Route::get('/harga', 'AdminHargaController@index')->name('admin.harga')->middleware('is_admin');
    Route::get('/create_admin', 'AdminUserController@createadmin')->name('admin.create_admin')->middleware('is_admin');

    Route::get('/setting', 'AdminSettingController@index')->name('admin.setting')->middleware('is_admin');
    Route::get('/create_harga', 'AdminSettingController@create')->name('admin.create_harga')->middleware('is_admin');
    Route::post('/store_harga', 'AdminSettingController@store')->name('admin.store_harga')->middleware('is_admin');
    Route::get('/edit_harga/{id}', 'AdminSettingController@edit')->name('admin.edit_harga')->middleware('is_admin');
    Route::post('/update_harga', 'AdminSettingController@update')->name('admin.update_harga')->middleware('is_admin');
    Route::get('/delete_harga/{id}', 'AdminSettingController@delete')->name('admin.delete_harga')->middleware('is_admin');

    Route::get('/profile', 'AdminProfileController@index')->name('admin.profile')->middleware('is_admin');

    Route::get('/monitoring', 'AdminHomeController@monitoring')->name('admin.monitoring')->middleware('is_admin');
    Route::get('/create_monitoring', 'AdminHomeController@create_monitoring')->name('admin.create_monitoring')->middleware('is_admin');
    Route::post('/store_monitoring', 'AdminHomeController@store_monitoring')->name('admin.store_monitoring')->middleware('is_admin');
    Route::get('/detail_monitoring/{id_monitoring}/{status}', 'AdminHomeController@detail_monitoring')->name('admin.detail_monitoring')->middleware('is_admin');
    Route::get('/edit_monitoring/{id_monitoring}', 'AdminHomeController@edit_monitoring')->name('admin.edit_monitoring')->middleware('is_admin');
    Route::post('/update_monitoring', 'AdminHomeController@update_monitoring')->name('admin.update_monitoring')->middleware('is_admin');
    Route::get('/tambah_monitoring/{id_monitoring}', 'AdminHomeController@tambah_monitoring')->name('admin.tambah_monitoring')->middleware('is_admin');
    Route::post('/store_tambah_monitoring', 'AdminHomeController@store_tambah_monitoring')->name('admin.store_tambah_monitoring')->middleware('is_admin');
    Route::get('/hasil_monitoring/{id_monitoring}', 'AdminHomeController@hasil_monitoring')->name('admin.hasil_monitoring')->middleware('is_admin');
    Route::post('/store_hasil_monitoring', 'AdminHomeController@store_hasil_monitoring')->name('admin.store_hasil_monitoring')->middleware('is_admin');
    Route::get('/delete_monitoring/{id_monitoring}', 'AdminHomeController@delete_monitoring')->name('admin.delete_monitoring')->middleware('is_admin');
    Route::get('/sisa_monitoring/{id_monitoring}', 'AdminHomeController@sisa_monitoring')->name('admin.sisa_monitoring')->middleware('is_admin');
    Route::get('/sisa_edit_monitoring/{id_monitoring}', 'AdminHomeController@sisa_edit_monitoring')->name('admin.sisa_edit_monitoring')->middleware('is_admin');
    Route::post('/store_sisa_monitoring', 'AdminHomeController@store_sisa_monitoring')->name('admin.store_sisa_monitoring')->middleware('is_admin');
    Route::post('/update_sisa_monitoring', 'AdminHomeController@update_sisa_monitoring')->name('admin.update_sisa_monitoring')->middleware('is_admin');
    Route::get('/create_rendaman/{id_monitoring}', 'AdminHomeController@create_rendaman')->name('admin.create_rendaman')->middleware('is_admin');
    Route::post('/update_rendaman', 'AdminHomeController@update_rendaman')->name('admin.update_rendaman')->middleware('is_admin');

    Route::get('/cetakmonitoring', 'AdminHomeController@cetakMonitoring')->name('admin.cetakmonitoring')->middleware('is_admin');

    Route::post('/sinkronisasi', 'AdminHomeController@sinkronisasi')->name('admin.sinkronisasi')->middleware('is_admin');

    Route::get('/transaksi', 'AdminHomeController@transaksi')->name('admin.transaksi')->middleware('is_admin');

    Route::get('/gaji', 'AdminGajiController@index')->name('admin.gaji')->middleware('is_admin');
    Route::get('/input_gaji', 'AdminGajiController@create')->name('admin.input_gaji')->middleware('is_admin');
    Route::post('/store_gaji', 'AdminGajiController@store')->name('admin.store_gaji')->middleware('is_admin');
    Route::get('/edit_gaji', 'AdminGajiController@edit')->name('admin.edit_gaji')->middleware('is_admin');
    Route::post('/update_gaji', 'AdminGajiController@update')->name('admin.update_gaji')->middleware('is_admin');

    Route::get('/kedelai', 'AdminKedelaiController@index')->name('admin.kedelai')->middleware('is_admin');
    Route::get('/input_kedelai', 'AdminKedelaiController@create')->name('admin.input_kedelai')->middleware('is_admin');
    Route::post('/store_kedelai', 'AdminKedelaiController@store')->name('admin.store_kedelai')->middleware('is_admin');
    Route::get('/edit_kedelai', 'AdminKedelaiController@edit')->name('admin.edit_kedelai')->middleware('is_admin');
    Route::post('/update_kedelai', 'AdminKedelaiController@update')->name('admin.update_kedelai')->middleware('is_admin');

    Route::get('/kulit', 'AdminKulitController@index')->name('admin.kulit')->middleware('is_admin');
    Route::get('/input_kulit', 'AdminKulitController@create')->name('admin.input_kulit')->middleware('is_admin');
    Route::post('/store_kulit', 'AdminKulitController@store')->name('admin.store_kulit')->middleware('is_admin');
    Route::get('/edit_kulit', 'AdminKulitController@edit')->name('admin.edit_kulit')->middleware('is_admin');
    Route::post('/update_kulit', 'AdminKulitController@update')->name('admin.update_kulit')->middleware('is_admin');
    Route::get('/detail_kulit', 'AdminKulitController@detail')->name('admin.detail_kulit')->middleware('is_admin');
    Route::get('/edit_data_kulit', 'AdminKulitController@edit_data_kulit')->name('admin.edit_data_kulit')->middleware('is_admin');
    Route::post('/update_data_kulit', 'AdminKulitController@update_data_kulit')->name('admin.update_data_kulit')->middleware('is_admin');
    Route::get('/kulit_bulanan', 'AdminKulitController@kulitBulanan')->name('admin.kulit_bulanan')->middleware('is_admin');

    Route::get('/pengeluaran', 'AdminPengeluaranController@index')->name('admin.pengeluaran')->middleware('is_admin');
    Route::get('/create_pengeluaran', 'AdminPengeluaranController@create')->name('admin.create_pengeluaran')->middleware('is_admin');
    Route::post('/store_pengeluaran', 'AdminPengeluaranController@store')->name('admin.store_pengeluaran')->middleware('is_admin');
    Route::get('/edit_pengeluaran/{id}', 'AdminPengeluaranController@edit')->name('admin.edit_pengeluaran')->middleware('is_admin');
    Route::post('/update_pengeluaran', 'AdminPengeluaranController@update')->name('admin.update_pengeluaran')->middleware('is_admin');
    Route::get('/delete_pengeluaran/{id}', 'AdminPengeluaranController@delete')->name('admin.delete_pengeluaran')->middleware('is_admin');

    Route::get('/debit', 'AdminDebitController@index')->name('admin.debit')->middleware('is_admin');
    Route::get('/input_debit', 'AdminDebitController@create')->name('admin.input_debit')->middleware('is_admin');
    Route::post('/store_debit', 'AdminDebitController@store')->name('admin.store_debit')->middleware('is_admin');
    Route::get('/edit_debit/{id}', 'AdminDebitController@edit')->name('admin.edit_debit')->middleware('is_admin');
    Route::post('/update_debit', 'AdminDebitController@update')->name('admin.update_debit')->middleware('is_admin');
    Route::get('/detail_debit', 'AdminDebitController@detail')->name('admin.detail_debit')->middleware('is_admin');
    Route::get('/delete_debit/{id}', 'AdminDebitController@delete')->name('admin.delete_debit')->middleware('is_admin');
    Route::get('/detail_pengeluaran', 'AdminDebitController@detail_pengeluaran')->name('admin.detail_pengeluaran')->middleware('is_admin');
    Route::get('/cetakkredit', 'AdminDebitController@cetakKredit')->name('admin.cetakkredit')->middleware('is_admin');

    Route::get('/setor_bank', 'AdminSetorBankController@index')->name('admin.setor_bank')->middleware('is_admin');
    Route::get('/input_setor_bank', 'AdminSetorBankController@create')->name('admin.input_setor_bank')->middleware('is_admin');
    Route::post('/store_setor_bank', 'AdminSetorBankController@store')->name('admin.store_setor_bank')->middleware('is_admin');
    Route::get('/edit_setor_bank', 'AdminSetorBankController@edit')->name('admin.edit_setor_bank')->middleware('is_admin');
    Route::put('/update_setor_bank', 'AdminSetorBankController@update')->name('admin.update_setor_bank')->middleware('is_admin');
    Route::get('/detail_setor_bank', 'AdminSetorBankController@detail')->name('admin.detail_setor_bank')->middleware('is_admin');
    Route::get('/delete_setor_bank/{id}', 'AdminSetorBankController@delete')->name('admin.delete_setor_bank')->middleware('is_admin');
    Route::get('/detail_pengeluaran', 'AdminSetorBankController@detail_pengeluaran')->name('admin.detail_pengeluaran')->middleware('is_admin');
    Route::get('/cetakkredit', 'AdminSetorBankController@cetakKredit')->name('admin.cetakkredit')->middleware('is_admin');

    Route::get('/hardcode', 'AdminHomeController@hardcode')->name('admin.hardcode')->middleware('is_admin');
});

Route::prefix('sales')->group(function () {
    Route::get('/home', 'SalesHomeController@index')->name('sales.home')->middleware('is_sales');
    Route::post('/lapor', 'SalesHomeController@lapor')->name('sales.lapor')->middleware('is_sales');
    Route::post('/input', 'SalesHomeController@input')->name('sales.input')->middleware('is_sales');
    Route::post('/sisa', 'SalesHomeController@sisa')->name('sales.sisa')->middleware('is_sales');
    Route::get('/list', 'SalesHomeController@list')->name('sales.list')->middleware('is_sales');
    Route::get('/detail/{id_laporan}', 'SalesHomeController@detail')->name('sales.detail')->middleware('is_sales');
    Route::get('/pdf', 'SalesHomeController@pdf')->name('sales.pdf')->middleware('is_sales');
    Route::get('/pdf-kasir', 'SalesHomeController@pdfKasir')->name('sales.pdf-kasir')->middleware('is_sales');
    Route::get('/cetakpdf', 'SalesHomeController@cetakpdf')->name('sales.cetakpdf')->middleware('is_sales');
    Route::post('/validasi', 'SalesHomeController@validasi')->name('sales.validasi')->middleware('is_sales');
});


Route::get('logs', [LogViewerController::class, 'index']);
Route::get('/log-sync-monitoring', [LogSyncMonitoringController::class, 'index'])->name('log.sync.monitoring')->middleware('is_admin');

Route::get('/adminer', function () {
    abort_unless(auth()->check(), 403);
    return redirect('/adminer.php');
});
