<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers | BridgeBox</title>
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
                    <h1>Teachers</h1>
                    <p class="subtext">Search and manage teachers in the BridgeBox system.</p>
                </div>
                <div class="actions">
                    <a class="btn primary" href="{{ route('admin.users.teachers.create') }}">Add Teacher</a>
                    <a class="btn ghost" href="{{ route('dashboard.admin') }}">Back to Dashboard</a>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="btn primary" type="submit">Logout</button>
                    </form>
                </div>
            </header>

            @if (session('message'))
                <div class="alert {{ session('status') === 'success' ? 'alert-success' : 'alert-error' }}" role="status">
                    {{ session('message') }}
                </div>
            @endif

            <section class="panel table-panel">
                <div class="panel-header">
                    <h4>Teachers List</h4>
                    <span class="badge blue">{{ $teachers->total() }}</span>
                </div>
                <div class="panel-body">
                    <div class="table-toolbar">
                        <form class="search-form" method="get" action="{{ route('admin.users.teachers.index') }}">
                            <input class="search-input" type="text" name="q" placeholder="Search by name or email" value="{{ $search }}">
                            <button class="btn ghost btn-small" type="submit">Search</button>
                            @if ($search)
                                <a class="btn ghost btn-small" href="{{ route('admin.users.teachers.index') }}">Clear</a>
                            @endif
                        </form>
                        <span class="text-muted">Showing {{ $teachers->count() }} of {{ $teachers->total() }}</span>
                    </div>

                    <div class="table-scroll">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($teachers as $teacher)
                                    <tr>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>{{ $teacher->phone ?: '-' }}</td>
                                        <td>
                                            <span class="badge {{ $teacher->is_active ? 'green' : 'rose' }}">
                                                {{ $teacher->is_active ? 'Active' : 'Disabled' }}
                                            </span>
                                        </td>
                                        <td>{{ $teacher->created_at?->format('Y-m-d') ?? '-' }}</td>
                                        <td>
                                            <div class="table-actions">
                                                <form method="post" action="{{ route('admin.users.toggle', $teacher) }}" data-confirm="Are you sure?">
                                                    @csrf
                                                    <button class="btn ghost btn-small" type="submit">
                                                        {{ $teacher->is_active ? 'Disable' : 'Enable' }}
                                                    </button>
                                                </form>
                                                <form method="post" action="{{ route('admin.users.reset', $teacher) }}" data-confirm="Reset password for this teacher?">
                                                    @csrf
                                                    <button class="btn ghost btn-small" type="submit">Reset Password</button>
                                                </form>
                                                <form method="post" action="{{ route('admin.users.delete', $teacher) }}" data-confirm="Delete this teacher account?">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn ghost btn-small" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="table-empty" colspan="6">No teachers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @include('admin.users.partials.pagination', ['paginator' => $teachers])
                </div>
            </section>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>
