<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Created | BridgeBox</title>
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>
<body>
    <div class="page">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-mark">
                    <img class="brand-logo" src="{{ asset('assets/images/favicon.png') }}" alt="BridgeBox logo">
                </div>
                <span class="brand-name">BridgeBox</span>
            </div>
            <nav class="nav">
                <a class="nav-item" href="{{ route('dashboard.admin') }}" aria-label="Admin control room">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M3 10.5L12 3l9 7.5"></path>
                        <path d="M5 9.5V21h14V9.5"></path>
                    </svg>
                </a>
                <a class="nav-item active" href="{{ route('admin.users.teachers.index') }}" aria-label="Manage teachers">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M4 7h16"></path>
                        <path d="M4 12h16"></path>
                        <path d="M4 17h10"></path>
                    </svg>
                </a>
                <a class="nav-item" href="{{ route('admin.users.students.index') }}" aria-label="Manage students">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M2 21a7 7 0 0 1 14 0"></path>
                        <circle cx="17" cy="7" r="3"></circle>
                        <path d="M16 14a6 6 0 0 1 6 6"></path>
                    </svg>
                </a>
                <a class="nav-item" href="{{ route('admin.classes.index') }}" aria-label="Manage classes">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M4 6h16v12H4z"></path>
                        <path d="M7 9h10"></path>
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
                    <p class="eyebrow">Admin User Management</p>
                    <h1>Teacher Created</h1>
                    <p class="subtext">The teacher account has been created successfully.</p>
                </div>
                <div class="actions">
                    <a class="btn ghost" href="{{ route('admin.users.teachers.index') }}">Back to Teachers</a>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn primary" type="submit">Logout</button>
                    </form>
                </div>
            </header>

            <section class="panel">
                <div class="panel-header">
                    <h4>Account Summary</h4>
                    <span class="badge blue">New</span>
                </div>
                <div class="panel-body">
                    <div class="item">
                        <div class="item-info">
                            <p>{{ $teacher->name }}</p>
                            <span>{{ $teacher->email }}</span>
                        </div>
                    </div>

                    @if ($passwordMode === 'auto' && $generatedPassword)
                        <div class="item">
                            <div class="item-info">
                                <p>Generated Password</p>
                                <span class="password-note">Shown once. Copy and share securely.</span>
                            </div>
                            <div class="password-box" data-copy-target>{{ $generatedPassword }}</div>
                            <button class="btn ghost btn-small" type="button" data-copy-button>Copy</button>
                        </div>
                    @else
                        <div class="item">
                            <div class="item-info">
                                <p>Password</p>
                                <span>Set manually during creation.</span>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script>
        const copyButton = document.querySelector('[data-copy-button]');
        const copyTarget = document.querySelector('[data-copy-target]');
        if (copyButton && copyTarget) {
            copyButton.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(copyTarget.textContent.trim());
                    copyButton.textContent = 'Copied';
                    setTimeout(() => {
                        copyButton.textContent = 'Copy';
                    }, 1500);
                } catch (error) {
                    copyButton.textContent = 'Copy failed';
                }
            });
        }
    </script>
</body>
</html>
