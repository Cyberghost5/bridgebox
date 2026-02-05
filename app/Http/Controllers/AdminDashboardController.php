<?php

namespace App\Http\Controllers;

use App\Services\SystemStatusService;

class AdminDashboardController extends Controller
{
    public function index(SystemStatusService $statusService)
    {
        $status = $statusService->snapshot();

        return view('dashboards.admin', [
            'status' => $status,
        ]);
    }
}
