<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Class | BridgeBox</title>
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-alerts.css') }}">
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
                <a class="nav-item" href="{{ route('dashboard.admin') }}" aria-label="Admin control room">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M3 10.5L12 3l9 7.5"></path>
                        <path d="M5 9.5V21h14V9.5"></path>
                    </svg>
                </a>
                <a class="nav-item" href="{{ route('admin.users.teachers.index') }}" aria-label="Manage teachers">
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
                <a class="nav-item active" href="{{ route('admin.classes.index') }}" aria-label="Manage classes">
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
                    <p class="eyebrow">Admin</p>
                    <h1>Edit Class</h1>
                    <p class="subtext">Update class details.</p>
                </div>
                <div class="actions">
                    <a class="btn ghost" href="{{ route('admin.classes.index') }}">Back to Classes</a>
                </div>
            </header>

            @if ($errors->any())
                <div class="alert alert-dismissible alert-error" role="status">
                    <span data-alert-message>There are validation errors. Please review the form.</span>
                    <button class="alert-close" type="button" data-alert-close data-bs-dismiss="alert" aria-label="Dismiss alert">×</button>
                </div>
            @endif

            <section class="panel">
                <div class="panel-header">
                    <h4>Class Details</h4>
                </div>
                <div class="panel-body">
                    <form action="{{ route('admin.classes.update', $class) }}" method="post">
                        @csrf
                        @method('put')
                        <div style="display:flex;flex-direction:column;gap:12px;max-width:640px;">
                            <label>
                                <div class="input-label">Name</div>
                                <input name="name" value="{{ old('name', $class->name) }}" required>
                            </label>

                            <label>
                                <div class="input-label">Slug (optional)</div>
                                <input name="slug" value="{{ old('slug', $class->slug) }}">
                            </label>

                            <label>
                                <div class="input-label">Description</div>
                                <textarea name="description">{{ old('description', $class->description) }}</textarea>
                            </label>

                            <div style="display:flex;gap:8px;">
                                <button class="btn primary" type="submit">Save Changes</button>
                                <a class="btn ghost" href="{{ route('admin.classes.index') }}">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>
