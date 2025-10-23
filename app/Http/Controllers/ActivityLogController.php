<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        // Bisa filter log berdasarkan user / tanggal
        $logs = ActivityLog::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.logs.index', compact('logs'));
    }
}
