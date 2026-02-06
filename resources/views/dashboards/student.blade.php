<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BridgeBox Student Dashboard</title>
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">
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
                    <i class="fa-solid fa-house" aria-hidden="true"></i>
                </button>
                <button class="nav-item" aria-label="Lessons">
                    <i class="fa-solid fa-book-open" aria-hidden="true"></i>
                </button>
                <button class="nav-item" aria-label="Progress">
                    <i class="fa-solid fa-chart-line" aria-hidden="true"></i>
                </button>
                <button class="nav-item" aria-label="Settings">
                    <i class="fa-solid fa-gear" aria-hidden="true"></i>
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
                        <i class="fa-solid fa-book-open" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p>Lessons Ready</p>
                        <span>5 available</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #e56b6f; --d: 0.1s;">
                    <div class="tab-icon">
                        <i class="fa-solid fa-circle-question" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p>Quizzes</p>
                        <span>2 due soon</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #f2b84b; --d: 0.15s;">
                    <div class="tab-icon">
                        <i class="fa-solid fa-download" aria-hidden="true"></i>
                    </div>
                    <div>
                        <p>Downloads</p>
                        <span>8 files saved</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #56c1a7; --d: 0.2s;">
                    <div class="tab-icon">
                        <i class="fa-solid fa-chart-line" aria-hidden="true"></i>
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
