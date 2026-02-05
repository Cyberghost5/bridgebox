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

        <main class="main">
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

            <section class="quick-tabs">
                <div class="tab" style="--accent: #4a7bd1; --d: 0.05s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <rect x="3" y="4" width="18" height="14" rx="2"></rect>
                        </svg>
                    </div>
                    <div>
                        <p>Server Status</p>
                        <span>{{ $status['server'] ?? 'Unknown' }}</span>
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
                        <span>{{ $status['hotspot'] ?? 'Unknown' }}</span>
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
                        <span>{{ $status['devices'] ?? 'Unknown' }}</span>
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
                        <span>{{ $status['app_health'] ?? 'Unknown' }}</span>
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
                        <span>{{ $status['storage'] ?? 'Unknown' }}</span>
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
                        <span>{{ $status['power'] ?? 'Unknown' }}</span>
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
                        <span>{{ $status['uptime'] ?? 'Unknown' }}</span>
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
                        <span>{{ $status['last_update'] ?? 'unknown' }}</span>
                    </div>
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h4>Admin Controls</h4>
                    <span class="badge gold">Placeholder</span>
                </div>
                <div class="panel-body">
                    <div class="item">
                        <div class="item-info">
                            <p>Start Server</p>
                            <span>nginx + php-fpm + SQLite permissions</span>
                        </div>
                        <button class="btn primary" type="button" disabled>Start</button>
                    </div>
                    <div class="item">
                        <div class="item-info">
                            <p>Stop Server</p>
                            <span>Gracefully stop services</span>
                        </div>
                        <button class="btn ghost" type="button" disabled>Stop</button>
                    </div>
                    <div class="item">
                        <div class="item-info">
                            <p>Hotspot Control</p>
                            <span>Turn hotspot on/off</span>
                        </div>
                        <div class="actions">
                            <button class="btn primary" type="button" disabled>On</button>
                            <button class="btn ghost" type="button" disabled>Off</button>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-info">
                            <p>Power Actions</p>
                            <span>Reboot or shutdown device</span>
                        </div>
                        <div class="actions">
                            <button class="btn primary" type="button" disabled>Reboot</button>
                            <button class="btn ghost" type="button" disabled>Shutdown</button>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>
