<?php

namespace App\Http\Controllers\Admin;

use App\Services\AdminActionService;
use App\Services\SystemStatusService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index(SystemStatusService $statusService, AdminActionService $actionService)
    {
        $status = $statusService->snapshot();
        $actionsEnabled = $actionService->isEnabled();
        $sudoAllowed = $actionService->isSudoAllowed();

        return view('dashboards.admin', [
            'status' => $status,
            'actionsEnabled' => $actionsEnabled,
            'sudoAllowed' => $sudoAllowed,
        ]);
    }

    public function status(SystemStatusService $statusService): JsonResponse
    {
        return response()->json($statusService->snapshot());
    }
}
