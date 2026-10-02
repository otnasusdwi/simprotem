<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    public static function generateYearRange() {
        $startYear = 2019;
        $currentYear = (int)date("Y");
        $futureYears = 5;

        $years = [];

        // Tambahkan tahun dari 2019 hingga tahun ini
        for ($year = $startYear; $year <= $currentYear; $year++) {
            $years[] = $year;
        }

        // Tambahkan 5 tahun setelah tahun ini
        for ($year = $currentYear + 1; $year <= $currentYear + $futureYears; $year++) {
            $years[] = $year;
        }

        return $years;
    }
}
