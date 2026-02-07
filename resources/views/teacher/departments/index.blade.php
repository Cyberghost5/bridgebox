@extends('teacher.layout')

@section('title', 'Departments')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Teacher</p>
                <h1>Departments</h1>
                <p class="subtext">Create and manage departments in the system.</p>
            </div>
            <div class="actions">
                <a class="btn primary" href="{{ route('teacher.departments.create') }}">Add Department</a>
                <a class="btn ghost" href="{{ route('dashboard.teacher') }}">Back to Dashboard</a>
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
                <h4>Departments List</h4>
                <span class="badge blue">{{ $departments->total() }}</span>
            </div>
            <div class="panel-body">
                <div class="table-toolbar">
                    <form class="search-form" method="get" action="{{ route('teacher.departments.index') }}">
                        <input class="search-input" type="text" name="q" placeholder="Search by name or code" value="{{ $search }}">
                        <button class="btn ghost btn-small" type="submit">Search</button>
                        @if ($search)
                            <a class="btn ghost btn-small" href="{{ route('teacher.departments.index') }}">Clear</a>
                        @endif
                    </form>
                    <span class="text-muted">Showing {{ $departments->count() }} of {{ $departments->total() }}</span>
                </div>

                <div class="table-scroll">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($departments as $department)
                                <tr>
                                    <td>{{ $department->name }}</td>
                                    <td>{{ $department->code ?: '-' }}</td>
                                    <td>{{ Str::limit($department->description, 60) }}</td>
                                    <td>{{ $department->created_at?->format('Y-m-d') ?? '-' }}</td>
                                    <td>
                                        <div class="table-actions">
                                            <a class="btn ghost btn-small" href="{{ route('teacher.departments.edit', $department) }}">Edit</a>
                                            <form method="post" action="{{ route('teacher.departments.delete', $department) }}" data-confirm="Delete this department?" style="display:inline-block;">
                                                @csrf
                                                @method('delete')
                                                <button class="btn ghost btn-small" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="table-empty" colspan="5">No departments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @include('admin.users.partials.pagination', ['paginator' => $departments])
            </div>
        </section>
    </main>
@endsection
