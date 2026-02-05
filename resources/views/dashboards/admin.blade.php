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
                    <span></span>
                    <span></span>
                </div>
                <span class="brand-name">BridgeBox</span>
            </div>
            <nav class="nav">
                <button class="nav-item active" aria-label="Admin overview">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M3 10.5L12 3l9 7.5"></path>
                        <path d="M5 9.5V21h14V9.5"></path>
                    </svg>
                </button>
                <button class="nav-item" aria-label="Devices">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <rect x="3" y="4" width="18" height="14" rx="2"></rect>
                        <path d="M7 18v2"></path>
                        <path d="M17 18v2"></path>
                    </svg>
                </button>
                <button class="nav-item" aria-label="Content packs">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M4 6h16v12H4z"></path>
                        <path d="M7 9h10"></path>
                        <path d="M7 13h6"></path>
                    </svg>
                </button>
                <button class="nav-item" aria-label="Settings">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <circle cx="12" cy="12" r="3.2"></circle>
                        <path d="M19.4 15a1 1 0 0 0 .2 1.1l.1.1a1.5 1.5 0 0 1-2.1 2.1l-.1-.1a1 1 0 0 0-1.1-.2 1 1 0 0 0-.6.9V19a1.5 1.5 0 0 1-3 0v-.1a1 1 0 0 0-.7-.9 1 1 0 0 0-1.1.2l-.1.1a1.5 1.5 0 0 1-2.1-2.1l.1-.1a1 1 0 0 0 .2-1.1 1 1 0 0 0-.9-.6H5a1.5 1.5 0 0 1 0-3h.1a1 1 0 0 0 .9-.7 1 1 0 0 0-.2-1.1l-.1-.1a1.5 1.5 0 1 1 2.1-2.1l.1.1a1 1 0 0 0 1.1.2 1 1 0 0 0 .6-.9V5a1.5 1.5 0 0 1 3 0v.1a1 1 0 0 0 .7.9 1 1 0 0 0 1.1-.2l.1-.1a1.5 1.5 0 1 1 2.1 2.1l-.1.1a1 1 0 0 0-.2 1.1 1 1 0 0 0 .9.6H19a1.5 1.5 0 0 1 0 3h-.1a1 1 0 0 0-.9.7z"></path>
                    </svg>
                </button>
            </nav>
            <div class="sidebar-footer">
                <div class="status-dot"></div>
                <span>Online</span>
            </div>
        </aside>

        <main class="main">
            <header class="topbar">
                <div class="greeting">
                    <p class="eyebrow">Admin Control Center</p>
                    <h1>Welcome back, {{ auth()->user()->name ?? 'Admin' }}.</h1>
                    <p class="subtext">Monitor schools, devices, and content health in one place.</p>
                </div>
                <div class="actions">
                    <button class="btn ghost">Review Requests</button>
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
                        <p>Active Schools</p>
                        <span>42 connected hubs</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #e56b6f; --d: 0.1s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M4 6h16v12H4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Devices Online</p>
                        <span>118 of 128 online</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #f2b84b; --d: 0.15s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M5 4h14a2 2 0 0 1 2 2v12H7a2 2 0 0 0-2 2V4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Content Packs</p>
                        <span>9 updates pending</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #56c1a7; --d: 0.2s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M3 7h18"></path>
                            <path d="M3 12h18"></path>
                            <path d="M3 17h18"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Support Tickets</p>
                        <span>6 awaiting review</span>
                    </div>
                </div>
            </section>

            <section class="panel table-panel">
                <div class="panel-header">
                    <h4>Admin Module Table</h4>
                    <span class="badge blue">Today</span>
                </div>
                <div class="panel-body table-scroll">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Module</th>
                                <th>Owner</th>
                                <th>Status</th>
                                <th>Last Sync</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Device Fleet</td>
                                <td>North Region Ops</td>
                                <td><span class="badge green">Stable</span></td>
                                <td>15 minutes ago</td>
                            </tr>
                            <tr>
                                <td>Content Library</td>
                                <td>Zee Tech</td>
                                <td><span class="badge teal">Review</span></td>
                                <td>1 hour ago</td>
                            </tr>
                            <tr>
                                <td>Access Control</td>
                                <td>BridgeBox Admin</td>
                                <td><span class="badge gold">Pending</span></td>
                                <td>Today 8:05 AM</td>
                            </tr>
                            <tr>
                                <td>Analytics Sync</td>
                                <td>Monitoring</td>
                                <td><span class="badge blue">Active</span></td>
                                <td>Yesterday</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>
