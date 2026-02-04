<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BridgeBox Dashboard</title>
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
                <button class="nav-item active" aria-label="Dashboard">
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
                <button class="nav-item" aria-label="Folders">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M3 6h6l2 2h10a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6z"></path>
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
                    <p class="eyebrow">Educator Dashboard</p>
                    <h1>Good afternoon, Amina.</h1>
                    <p class="subtext">Here is a focused snapshot of your classroom today.</p>
                </div>
                <div class="actions">
                    <button class="btn ghost">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M4 7h16"></path>
                            <path d="M4 12h10"></path>
                            <path d="M4 17h7"></path>
                        </svg>
                        Create Quiz
                    </button>
                    <button class="btn primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M12 5v14"></path>
                            <path d="M5 12h14"></path>
                        </svg>
                        Add Content
                    </button>
                    <div class="avatar" aria-label="Profile">AE</div>
                </div>
            </header>

            <section class="quick-tabs">
                <div class="tab" style="--accent: #4a7bd1; --d: 0.05s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <rect x="3" y="4" width="18" height="14" rx="2"></rect>
                            <path d="M7 18v2"></path>
                            <path d="M17 18v2"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Students</p>
                        <span>224 learners</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #e56b6f; --d: 0.1s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M4 6h16v12H4z"></path>
                            <path d="M7 9h10"></path>
                            <path d="M7 13h6"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Content Files</p>
                        <span>92 uploads</span>
                    </div>
                </div>
                <div class="tab" style="--accent: #f2b84b; --d: 0.15s;">
                    <div class="tab-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M7 3h10v4H7z"></path>
                            <path d="M5 7h14v13H5z"></path>
                            <path d="M9 11h6"></path>
                        </svg>
                    </div>
                    <div>
                        <p>Pending Assignments</p>
                        <span>18 waiting</span>
                    </div>
                </div>
                <div class="tab tab-highlight" style="--d: 0.2s;">
                    <div class="tab-photo"></div>
                    <div>
                        <p>Classroom Moments</p>
                        <span>New gallery added</span>
                    </div>
                </div>
            </section>

            <section class="subject-grid">
                <article class="subject-card" style="--tone: #5b8de3; --d: 0.05s;">
                    <div class="subject-media tone-1">
                        <div class="media-shape"></div>
                        <div class="media-shape alt"></div>
                        <span>Algebra</span>
                    </div>
                    <div class="subject-footer">
                        <div class="subject-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M4 5h16"></path>
                                <path d="M4 12h16"></path>
                                <path d="M4 19h16"></path>
                            </svg>
                        </div>
                        <div>
                            <h3>Mathematics</h3>
                            <p>12 lessons this week</p>
                        </div>
                    </div>
                </article>
                <article class="subject-card" style="--tone: #f08b5a; --d: 0.1s;">
                    <div class="subject-media tone-2">
                        <div class="media-shape"></div>
                        <div class="media-shape alt"></div>
                        <span>Reading Lab</span>
                    </div>
                    <div class="subject-footer">
                        <div class="subject-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M6 4h8a4 4 0 0 1 4 4v12H6a3 3 0 0 1-3-3V7a3 3 0 0 1 3-3z"></path>
                                <path d="M6 8h8"></path>
                            </svg>
                        </div>
                        <div>
                            <h3>English Language</h3>
                            <p>Vocabulary and literacy</p>
                        </div>
                    </div>
                </article>
                <article class="subject-card" style="--tone: #3bb98d; --d: 0.15s;">
                    <div class="subject-media tone-3">
                        <div class="media-shape"></div>
                        <div class="media-shape alt"></div>
                        <span>Lab Time</span>
                    </div>
                    <div class="subject-footer">
                        <div class="subject-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M10 2v6l-5.5 9.5a3 3 0 0 0 2.6 4.5h9.8a3 3 0 0 0 2.6-4.5L14 8V2"></path>
                                <path d="M8 8h8"></path>
                            </svg>
                        </div>
                        <div>
                            <h3>Basic Science</h3>
                            <p>3 experiments queued</p>
                        </div>
                    </div>
                </article>
                <article class="subject-card" style="--tone: #e45757; --d: 0.2s;">
                    <div class="subject-media tone-4">
                        <div class="media-shape"></div>
                        <div class="media-shape alt"></div>
                        <span>History Lab</span>
                    </div>
                    <div class="subject-footer">
                        <div class="subject-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                <path d="M5 5h14v4H5z"></path>
                                <path d="M7 9v10h10V9"></path>
                                <path d="M12 12v4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3>Social Studies</h3>
                            <p>Community project</p>
                        </div>
                    </div>
                </article>
            </section>

            <section class="lower-grid">
                <div class="panel uploads" style="--d: 0.05s;">
                    <div class="panel-header">
                        <h4>Recent Uploads</h4>
                        <button class="icon-btn" aria-label="More">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                    <div class="panel-body">
                        <div class="item">
                            <div class="item-icon tone-blue">CF</div>
                            <div class="item-info">
                                <p>Curriculum Materials</p>
                                <span>Updated 2 hours ago</span>
                            </div>
                            <span class="badge blue">Review</span>
                        </div>
                        <div class="item">
                            <div class="item-icon tone-coral">SS</div>
                            <div class="item-info">
                                <p>Semester Smarts</p>
                                <span>Updated yesterday</span>
                            </div>
                            <span class="badge green">Shared</span>
                        </div>
                        <div class="item">
                            <div class="item-icon tone-indigo">IS</div>
                            <div class="item-info">
                                <p>Internet Submission</p>
                                <span>Updated 3 days ago</span>
                            </div>
                            <span class="badge teal">In review</span>
                        </div>
                        <div class="item">
                            <div class="item-icon tone-olive">ED</div>
                            <div class="item-info">
                                <p>Education Toolkit</p>
                                <span>Updated last week</span>
                            </div>
                            <span class="badge gold">Archive</span>
                        </div>
                    </div>
                </div>

                <div class="panel tests" style="--d: 0.1s;">
                    <div class="panel-header">
                        <h4>Upcoming Tests</h4>
                        <button class="icon-btn" aria-label="More">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                    <div class="panel-body">
                        <div class="item">
                            <div class="item-icon tone-blue">TU</div>
                            <div class="item-info">
                                <p>Tuesday February 10</p>
                                <span>English Grammar</span>
                            </div>
                            <span class="badge coral">Due 2d</span>
                        </div>
                        <div class="item">
                            <div class="item-icon tone-rose">MG</div>
                            <div class="item-info">
                                <p>Magic Geometry</p>
                                <span>Problem set 4</span>
                            </div>
                            <span class="badge rose">Due 4d</span>
                        </div>
                        <div class="item">
                            <div class="item-icon tone-mint">BS</div>
                            <div class="item-info">
                                <p>Biology Sprint</p>
                                <span>Lab safety quiz</span>
                            </div>
                            <span class="badge green">Due 6d</span>
                        </div>
                    </div>
                </div>

                <div class="panel activity" style="--d: 0.15s;">
                    <div class="panel-header">
                        <h4>Student Activity</h4>
                        <button class="icon-btn" aria-label="More">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                    <div class="panel-body">
                        <div class="chart">
                            <div class="bar" data-value="72"><span>Mon</span></div>
                            <div class="bar" data-value="48"><span>Tue</span></div>
                            <div class="bar" data-value="82"><span>Wed</span></div>
                            <div class="bar" data-value="60"><span>Thu</span></div>
                            <div class="bar" data-value="52"><span>Fri</span></div>
                            <div class="bar" data-value="40"><span>Sat</span></div>
                            <div class="bar" data-value="68"><span>Sun</span></div>
                        </div>
                    </div>
                </div>

                <div class="panel status" style="--d: 0.2s;">
                    <div class="panel-header">
                        <h4>System Status</h4>
                        <div class="dots">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="status-item">
                            <div>
                                <p>Practice Quiz</p>
                                <span>Uploads synced</span>
                            </div>
                            <div class="meter">
                                <div class="meter-fill" data-progress="78"></div>
                            </div>
                        </div>
                        <div class="status-item">
                            <div>
                                <p>Lesson Plans</p>
                                <span>Reviewed items</span>
                            </div>
                            <div class="meter">
                                <div class="meter-fill" data-progress="54"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel meters" style="--d: 0.25s;">
                    <div class="panel-header">
                        <h4>Device Health</h4>
                        <button class="icon-btn" aria-label="More">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                    <div class="panel-body">
                        <div class="status-item compact">
                            <div class="item-icon tone-green">B</div>
                            <div class="item-info">
                                <p>Battery</p>
                                <span>6 hours remaining</span>
                            </div>
                            <div class="meter thin">
                                <div class="meter-fill" data-progress="64"></div>
                            </div>
                        </div>
                        <div class="status-item compact">
                            <div class="item-icon tone-blue">S</div>
                            <div class="item-info">
                                <p>Storage</p>
                                <span>148 GB free</span>
                            </div>
                            <div class="meter thin">
                                <div class="meter-fill" data-progress="42"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>

