<?php

namespace App\Http\Controllers;

use App\Models\LogSyncMonitoring;

class LogSyncMonitoringController extends Controller
{
    public function index()
    {
        $logs = LogSyncMonitoring::orderBy('created_at', 'desc')->limit(10)->get();
        return response()->json($logs);
    }
}
