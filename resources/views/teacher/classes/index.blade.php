@extends('teacher.layout')

@section('title', 'Classes')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Teacher</p>
                <h1>Classes</h1>
                <p class="subtext">Your assigned classes and schedules.</p>
            </div>
            <div class="actions">
                <a class="btn primary" href="{{ route('teacher.classes.create') }}">Add Class</a>
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
                <h4>Classes List</h4>
                <span class="badge blue">{{ $classes->total() }}</span>
            </div>
            <div class="panel-body">
                <div class="table-toolbar">
                    <form class="search-form" method="get" action="{{ route('teacher.classes.index') }}">
                        <input class="search-input" type="text" name="q" placeholder="Search by name or slug" value="{{ $search }}">
                        <button class="btn ghost btn-small" type="submit">Search</button>
                        @if ($search)
                            <a class="btn ghost btn-small" href="{{ route('teacher.classes.index') }}">Clear</a>
                        @endif
                    </form>
                    <span class="text-muted">Showing {{ $classes->count() }} of {{ $classes->total() }}</span>
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
                            @forelse ($classes as $class)
                                <tr>
                                    <td>{{ $class->name }}</td>
                                    <td>{{ $class->slug }}</td>
                                    <td>{{ Str::limit($class->description, 60) }}</td>
                                    <td>{{ $class->created_at?->format('Y-m-d') ?? '-' }}</td>
                                    <td>
                                        <div class="table-actions">
                                            <a class="btn ghost btn-small" href="{{ route('teacher.classes.edit', $class) }}">Edit</a>
                                            <form method="post" action="{{ route('teacher.classes.delete', $class) }}" data-confirm="Delete this class?" style="display:inline-block;">
                                                @csrf
                                                @method('delete')
                                                <button class="btn ghost btn-small" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="table-empty" colspan="5">No classes found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @include('admin.users.partials.pagination', ['paginator' => $classes])
            </div>
        </section>
    </main>
@endsection
