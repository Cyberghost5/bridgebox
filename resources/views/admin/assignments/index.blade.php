@extends('admin.layout')

@section('title', 'Assignments')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Admin</p>
                <h1>Assignments</h1>
                <p class="subtext">Create and manage assignments based on lessons.</p>
            </div>
            <div class="actions">
                <a class="btn primary" href="{{ route('admin.assignments.create') }}">Add Assignment</a>
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
                <h4>Assignments List</h4>
                <span class="badge blue">{{ $assignments->total() }}</span>
            </div>
            <div class="panel-body">
                <div class="table-toolbar">
                    <form class="search-form" method="get" action="{{ route('admin.assignments.index') }}">
                        <input class="search-input" type="text" name="q" placeholder="Search by title" value="{{ $search }}">
                        <button class="btn ghost btn-small" type="submit">Search</button>
                        @if ($search)
                            <a class="btn ghost btn-small" href="{{ route('admin.assignments.index') }}">Clear</a>
                        @endif
                    </form>
                    <span class="text-muted">Showing {{ $assignments->count() }} of {{ $assignments->total() }}</span>
                </div>

                <div class="table-scroll">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Lesson</th>
                                <th>Topic</th>
                                <th>Due</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assignments as $index => $assignment)
                                <tr>
                                    <td>{{ $assignments->firstItem() + $index }}</td>
                                    <td>{{ $assignment->title }}</td>
                                    <td>{{ $assignment->lesson?->title ?? '-' }}</td>
                                    <td>{{ $assignment->lesson?->topic?->title ?? '-' }}</td>
                                    <td>{{ $assignment->due_at?->format('Y-m-d') ?? '-' }}</td>
                                    <td>
                                        <div class="table-actions">
                                            <a class="btn ghost btn-small" href="{{ route('admin.assignments.submissions.index', $assignment) }}">Submissions</a>
                                            <a class="btn ghost btn-small" href="{{ route('admin.assignments.edit', $assignment) }}">Edit</a>
                                            <form method="post" action="{{ route('admin.assignments.delete', $assignment) }}" data-confirm="Delete this assignment?" style="display:inline-block;">
                                                @csrf
                                                @method('delete')
                                                <button class="btn ghost btn-small" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="table-empty" colspan="6">No assignments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @include('admin.users.partials.pagination', ['paginator' => $assignments])
            </div>
        </section>
    </main>
@endsection
