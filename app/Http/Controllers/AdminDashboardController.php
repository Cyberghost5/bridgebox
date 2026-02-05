<?php

namespace App\Http\Controllers;

use App\Services\AdminActionService;
use App\Services\SystemStatusService;
use App\Models\AdminActionLog;
use Illuminate\Http\JsonResponse;

class AdminDashboardController extends Controller
{
    public function index(SystemStatusService $statusService, AdminActionService $actionService)
    {
        $status = $statusService->snapshot();
        $logs = AdminActionLog::with('user')->latest()->limit(10)->get();
        $actionsEnabled = $actionService->isEnabled();
        $sudoAllowed = $actionService->isSudoAllowed();

        return view('dashboards.admin', [
            'status' => $status,
            'logs' => $logs,
            'actionsEnabled' => $actionsEnabled,
            'sudoAllowed' => $sudoAllowed,
        ]);
    }

    public function status(SystemStatusService $statusService): JsonResponse
    {
        return response()->json($statusService->snapshot());
    }
}
