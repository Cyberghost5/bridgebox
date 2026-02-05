<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BridgeBox Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>
<body>
    <div class="page">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-mark">
                    <img class="brand-logo" src="{{ asset('assets/images/favicon.png') }}" alt="BridgeBox logo">
                    <!-- <span></span>
                    <span></span> -->
                </div>
                <span class="brand-name">BridgeBox</span>
            </div>
            <nav class="nav">
                <a class="nav-item active" href="{{ route('dashboard.admin') }}" aria-label="Admin control room">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M3 10.5L12 3l9 7.5"></path>
                        <path d="M5 9.5V21h14V9.5"></path>
                    </svg>
                </a>
                <button class="nav-item" aria-label="System status">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M4 18l6-6 4 4 6-8"></path>
                    </svg>
                </button>
                <button class="nav-item" aria-label="Admin actions">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M4 6h16v12H4z"></path>
                        <path d="M7 9h10"></path>
                        <path d="M7 13h6"></path>
                    </svg>
                </button>
            </nav>
            <div class="sidebar-footer">
                <div class="status-dot"></div>
                <span>Admin</span>
            </div>
        </aside>

        <main class="main" data-refresh-url="{{ route('dashboard.admin.status') }}" data-refresh-interval="10000" data-auto-refresh="on">
            <header class="topbar">
                <div class="greeting">
                    <p class="eyebrow">Admin Control Room</p>
                    <h1>Welcome, {{ auth()->user()->name ?? 'Admin' }}.</h1>
                    <p class="subtext">Monitor system health and manage critical services.</p>
                </div>
                <div class="actions">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn primary" type="submit">Logout</button>
                    </form>
                </div>
            </header>

            @php
                $flashStatus = session('action_status');
                $flashMessage = session('action_message');
                $actionsBlocked = (!$actionsEnabled) || (!$sudoAllowed);
            @endphp
            <div id="action-alert" class="alert {{ $flashStatus === 'success' ? 'alert-success' : ($flashStatus === 'error' ? 'alert-error' : '') }}" role="status" aria-live="polite" @if (!$flashMessage) hidden @endif>
                {{ $flashMessage }}
            </div>
            @if (!$actionsEnabled)
                <div class="alert alert-warning">
                    Admin actions are disabled. Set <code>ADMIN_ACTIONS_ENABLED=true</code> in <code>.env</code> to enable them.
                </div>
            @elseif (!$sudoAllowed)
                <div class="alert alert-warning">
                    Sudo actions are disabled. Configure sudoers and set <code>ADMIN_ACTIONS_ALLOW_SUDO=true</code> to allow system commands.
                </div>
            @endif

            <section class="quick-tabs">
                <div class="tab" style="--accent: #4a7bd1; --d: 0.05s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <rect x="3" y="4" width="18" height="14" rx="2"></rect>
                        </svg>
                    </div>
                    <div>
                        <p>Server Status</p>
                        <span data-status="server">{{ $status['server'] ?? 'Unknown' }}</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #e56b6f; --d: 0.1s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M3 7h18"></path>
                            <path d="M3 12h18"></path>
                            <path d="M3 17h18"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Hotspot Status</p>
                        <span data-status="hotspot">{{ $status['hotspot'] ?? 'Unknown' }}</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #f2b84b; --d: 0.15s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M4 6h16v12H4z"></path>
                            <path d="M7 9h10"></path>
                            <path d="M7 13h6"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Connected Devices</p>
                        <span data-status="devices">{{ $status['devices'] ?? 'Unknown' }}</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #56c1a7; --d: 0.2s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M4 4h16v16H4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p>App Health</p>
                        <span data-status="app_health">{{ $status['app_health'] ?? 'Unknown' }}</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #5b8de3; --d: 0.25s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M3 6h18v12H3z"></path>
                            <path d="M8 18v2"></path>
                            <path d="M16 18v2"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Storage</p>
                        <span data-status="storage">{{ $status['storage'] ?? 'Unknown' }}</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #f08b5a; --d: 0.3s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M12 2v6"></path>
                            <path d="M8 4h8"></path>
                            <path d="M6 8h12"></path>
                            <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Power Health</p>
                        <span data-status="power">{{ $status['power'] ?? 'Unknown' }}</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #3bb98d; --d: 0.35s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <circle cx="12" cy="12" r="9"></circle>
                            <path d="M12 7v6l3 3"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Uptime</p>
                        <span data-status="uptime">{{ $status['uptime'] ?? 'Unknown' }}</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #e45757; --d: 0.4s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M6 2v4"></path>
                            <path d="M18 2v4"></path>
                            <rect x="3" y="4" width="18" height="17" rx="2"></rect>
                            <path d="M3 9h18"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Last Update</p>
                        <span data-status="last_update">{{ $status['last_update'] ?? 'unknown' }}</span>
                    </div>
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h4>Admin Controls</h4>
                    <span class="badge gold">Actions</span>
                </div>
                <div class="panel-body">
                    <form class="item" data-admin-action data-confirm="Start the server services?" action="{{ route('dashboard.admin.actions', ['action' => 'start_server']) }}" method="post">
                        @csrf
                        <div class="item-info">
                            <p>Start Server</p>
                            <span>nginx + php-fpm + SQLite permissions check</span>
                        </div>
                        <button class="btn primary" type="submit" @disabled($actionsBlocked)>Start</button>
                    </form>
                    <form class="item" data-admin-action data-confirm="Stop the server services?" action="{{ route('dashboard.admin.actions', ['action' => 'stop_server']) }}" method="post">
                        @csrf
                        <div class="item-info">
                            <p>Stop Server</p>
                            <span>Gracefully stop services</span>
                        </div>
                        <button class="btn ghost" type="submit" @disabled($actionsBlocked)>Stop</button>
                    </form>
                    <div class="item">
                        <div class="item-info">
                            <p>Hotspot Control</p>
                            <span>Turn hotspot on/off</span>
                        </div>
                        <div class="inline-actions">
                            <form data-admin-action data-confirm="Turn hotspot on?" action="{{ route('dashboard.admin.actions', ['action' => 'hotspot_on']) }}" method="post">
                                @csrf
                                <button class="btn primary" type="submit" @disabled($actionsBlocked)>On</button>
                            </form>
                            <form data-admin-action data-confirm="Turn hotspot off?" action="{{ route('dashboard.admin.actions', ['action' => 'hotspot_off']) }}" method="post">
                                @csrf
                                <button class="btn ghost" type="submit" @disabled($actionsBlocked)>Off</button>
                            </form>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-info">
                            <p>Power Actions</p>
                            <span>Reboot or shutdown device</span>
                        </div>
                        <div class="inline-actions">
                            <form data-admin-action data-confirm="Reboot the device now?" action="{{ route('dashboard.admin.actions', ['action' => 'reboot']) }}" method="post">
                                @csrf
                                <button class="btn primary" type="submit" @disabled($actionsBlocked)>Reboot</button>
                            </form>
                            <form data-admin-action data-confirm="Shutdown the device now?" action="{{ route('dashboard.admin.actions', ['action' => 'shutdown']) }}" method="post">
                                @csrf
                                <button class="btn ghost" type="submit" @disabled($actionsBlocked)>Shutdown</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <section class="panel table-panel">
                <div class="panel-header">
                    <h4>Recent Admin Actions</h4>
                    <span class="badge blue">Last 10</span>
                </div>
                <div class="panel-body table-scroll">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Time</th>
                                <th>Admin</th>
                                <th>Action</th>
                                <th>Result</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody data-action-log-body>
                            @forelse ($logs as $log)
                                <tr>
                                    <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                                    <td>{{ $log->user->name ?? 'Unknown' }}</td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ ucfirst($log->result) }}</td>
                                    <td>{{ $log->message }}</td>
                                </tr>
                            @empty
                                <tr data-action-log-empty>
                                    <td colspan="5">No actions logged yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <div class="modal" id="confirm-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="confirm-title">
        <div class="modal-card">
            <div class="modal-header">
                <h3 id="confirm-title">Confirm Action</h3>
                <button class="icon-close" type="button" data-confirm-close aria-label="Close dialog">×</button>
            </div>
            <p class="modal-message" data-confirm-message>Are you sure?</p>
            <div class="modal-actions">
                <button class="btn ghost" type="button" data-confirm-no>Cancel</button>
                <button class="btn primary" type="button" data-confirm-yes>Confirm</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/admin-actions.js') }}"></script>
    <script src="{{ asset('assets/js/admin-dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>
