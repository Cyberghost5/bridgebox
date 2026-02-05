<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BridgeBox Student Dashboard</title>
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
                <button class="nav-item active" aria-label="Student overview">
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
                <button class="nav-item" aria-label="Progress">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M4 18l6-6 4 4 6-8"></path>
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
                    <p class="eyebrow">Student Hub</p>
                    <h1>Keep going, {{ auth()->user()->name ?? 'Student' }}.</h1>
                    <p class="subtext">Pick up where you left off and track your progress.</p>
                </div>
                <div class="actions">
                    <button class="btn ghost">Resume Lesson</button>
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
                        <p>Lessons Ready</p>
                        <span>5 available</span>
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
                        <p>Quizzes</p>
                        <span>2 due soon</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #f2b84b; --d: 0.15s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M5 4h14a2 2 0 0 1 2 2v12H7a2 2 0 0 0-2 2V4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Downloads</p>
                        <span>8 files saved</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #56c1a7; --d: 0.2s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M4 4h16v16H4z"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Progress</p>
                        <span>68% weekly goal</span>
                    </div>
                </div>
            </section>

            <section class="panel table-panel">
                <div class="panel-header">
                    <h4>Student Module Table</h4>
                    <span class="badge coral">Today</span>
                </div>
                <div class="panel-body table-scroll">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Subject</th>
                                <th>Task</th>
                                <th>Due</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Mathematics</td>
                                <td>Fractions Practice</td>
                                <td>Today 5:00 PM</td>
                                <td><span class="badge gold">In Progress</span></td>
                            </tr>
                            <tr>
                                <td>English</td>
                                <td>Reading Comprehension</td>
                                <td>Tomorrow</td>
                                <td><span class="badge blue">Assigned</span></td>
                            </tr>
                            <tr>
                                <td>Science</td>
                                <td>Lab Notes</td>
                                <td>Friday</td>
                                <td><span class="badge green">Ready</span></td>
                            </tr>
                            <tr>
                                <td>Social Studies</td>
                                <td>Community Map</td>
                                <td>Next Week</td>
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
