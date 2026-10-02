<?php
namespace App\Console\Commands;

use App\Http\Controllers\AdminHomeController;
use App\Models\HargaMonitoring;
use App\Models\ItemMonitoring;
use App\Models\LogSyncMonitoring;
use App\Models\Monitoring;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class SyncMonitoringData extends Command
{
    protected $signature   = 'sync:monitoring';
    protected $description = 'Sinkronisasi data monitoring dari 7 hari terakhir setiap hari jam 1 malam';

    public function handle()
    {
        $output      = new ConsoleOutput();
        $tgl_laporan = Carbon::now()->subDays(7)->toDateString();
        $this->info("🔄 Mengambil data monitoring dari tanggal: $tgl_laporan");

        $monitoringData = Monitoring::whereDate('tgl_laporan', '>=', $tgl_laporan)->get();

        if ($monitoringData->isEmpty()) {
            $this->info('❌ Tidak ada data monitoring untuk disinkronkan.');
            return;
        }

        // Simpan log awal
        $log = LogSyncMonitoring::create([
            'start_date' => $tgl_laporan,
            'end_date'   => Carbon::now()->toDateString(),
            'total_data' => count($monitoringData),
            'status'     => 'Proses',
        ]);

        $progressBar = new ProgressBar($output, count($monitoringData));
        $progressBar->start();

        $adminController = new AdminHomeController();
        $processedCount  = 0;

        foreach ($monitoringData as $monitoring) {
            $id_monitoring = $monitoring->id_monitoring;
            $tgl_laporan   = $monitoring->tgl_laporan;

            $userIds = ItemMonitoring::where('id_monitoring', $id_monitoring)
                ->distinct()
                ->pluck('id_user');

            $users = User::whereIn('id', $userIds)->get();
            $harga = HargaMonitoring::where('id_monitoring', $id_monitoring)
                ->pluck('harga');

            if ($users->isEmpty() || $harga->isEmpty()) {
                $this->warn("⚠️ Data tidak lengkap untuk ID Monitoring: $id_monitoring, dilewati.");
                $progressBar->advance();
                continue;
            }

            $request = new Request([
                'tgl_laporan'   => $tgl_laporan,
                'users'         => $users->toArray(),
                'harga'         => $harga->toArray(),
                'id_monitoring' => $id_monitoring,
            ]);

            $adminController->sinkronisasi($request, true);

            $processedCount++;
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->info("\n🎯 Sinkronisasi monitoring selesai.");

        // Update log dengan hasil akhir
        $log->update([
            'total_data' => $processedCount,
            'status'     => 'Sukses',
        ]);
    }

}
