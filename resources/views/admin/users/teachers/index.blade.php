@extends('admin.layout')

@section('title', 'Teachers')

@section('main')
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
            <div class="alert alert-dismissible {{ session('status') === 'success' ? 'alert-success' : 'alert-error' }}" role="status" data-auto-dismiss="4000">
                <span data-alert-message>{{ session('message') }}</span>
                <button class="alert-close" type="button" data-alert-close data-bs-dismiss="alert" aria-label="Dismiss alert">&times;</button>
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
                                <th>Class</th>
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
                                        <td>{{ $teacher->schoolClass?->name ?? '-' }}</td>
                                        <td>
                                            <span class="badge {{ $teacher->is_active ? 'green' : 'rose' }}">
                                                {{ $teacher->is_active ? 'Active' : 'Disabled' }}
                                            </span>
                                        </td>
                                        <td>{{ $teacher->created_at?->format('Y-m-d') ?? '-' }}</td>
                                        <td>
                                            <div class="table-actions">
                                                <a class="btn ghost btn-small" href="{{ route('admin.users.teachers.edit', $teacher) }}">Edit</a>
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
@endsection
