<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BridgeBox Teacher Dashboard</title>
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
                <button class="nav-item active" aria-label="Teacher overview">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M3 10.5L12 3l9 7.5"></path>
                        <path d="M5 9.5V21h14V9.5"></path>
                    </svg>
                </button>
                <button class="nav-item" aria-label="Lessons">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M5 4h14a2 2 0 0 1 2 2v12H7a2 2 0 0 0-2 2V4z"></path>
                        <path d="M7 8h10"></path>
                        <path d="M7 12h6"></path>
                    </svg>
                </button>
                <button class="nav-item" aria-label="Calendar">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <rect x="3" y="4" width="18" height="17" rx="2"></rect>
                        <path d="M8 2v4M16 2v4M3 9h18"></path>
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
                    <p class="eyebrow">Teacher Workspace</p>
                    <h1>Hello, {{ auth()->user()->name ?? 'Teacher' }}.</h1>
                    <p class="subtext">Your lessons, learners, and resources in one flow.</p>
                </div>
                <div class="actions">
                    <button class="btn ghost">Create Lesson</button>
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
                            <path d="M4 6h16v12H4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Active Classes</p>
                        <span>6 sections</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #e56b6f; --d: 0.1s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M7 3h10v4H7z"></path>
                            <path d="M5 7h14v13H5z"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Assignments</p>
                        <span>18 pending</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #f2b84b; --d: 0.15s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M5 4h14a2 2 0 0 1 2 2v12H7a2 2 0 0 0-2 2V4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Lesson Packs</p>
                        <span>4 new uploads</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #56c1a7; --d: 0.2s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M4 4h16v16H4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Attendance</p>
                        <span>92% today</span>
                    </div>
                </div>
            </section>

            <section class="panel table-panel">
                <div class="panel-header">
                    <h4>Teacher Module Table</h4>
                    <span class="badge teal">This Week</span>
                </div>
                <div class="panel-body table-scroll">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Topic</th>
                                <th>Next Session</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>JSS 2A</td>
                                <td>Fractions Review</td>
                                <td>Wed 10:00 AM</td>
                                <td><span class="badge green">Ready</span></td>
                            </tr>
                            <tr>
                                <td>JSS 3B</td>
                                <td>Reading Lab</td>
                                <td>Thu 1:30 PM</td>
                                <td><span class="badge gold">Draft</span></td>
                            </tr>
                            <tr>
                                <td>SSS 1</td>
                                <td>Intro to Biology</td>
                                <td>Fri 9:00 AM</td>
                                <td><span class="badge blue">Scheduled</span></td>
                            </tr>
                            <tr>
                                <td>SSS 2</td>
                                <td>Algebra Practice</td>
                                <td>Fri 12:00 PM</td>
                                <td><span class="badge teal">Shared</span></td>
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
