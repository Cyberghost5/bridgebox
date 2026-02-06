@extends('admin.layout')

@section('title', 'Subjects')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Admin</p>
                <h1>Subjects</h1>
                <p class="subtext">Create and manage subjects in the system.</p>
            </div>
            <div class="actions">
                <a class="btn primary" href="{{ route('admin.subjects.create') }}">Add Subject</a>
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
                <h4>Subjects List</h4>
                <span class="badge blue">{{ $subjects->total() }}</span>
            </div>
            <div class="panel-body">
                <div class="table-toolbar">
                    <form class="search-form" method="get" action="{{ route('admin.subjects.index') }}">
                        <input class="search-input" type="text" name="q" placeholder="Search by name or code" value="{{ $search }}">
                        <button class="btn ghost btn-small" type="submit">Search</button>
                        @if ($search)
                            <a class="btn ghost btn-small" href="{{ route('admin.subjects.index') }}">Clear</a>
                        @endif
                    </form>
                    <span class="text-muted">Showing {{ $subjects->count() }} of {{ $subjects->total() }}</span>
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
                            @forelse ($subjects as $subject)
                                <tr>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->code ?: '-' }}</td>
                                    <td>{{ Str::limit($subject->description, 60) }}</td>
                                    <td>{{ $subject->created_at?->format('Y-m-d') ?? '-' }}</td>
                                    <td>
                                        <div class="table-actions">
                                            <a class="btn ghost btn-small" href="{{ route('admin.subjects.edit', $subject) }}">Edit</a>
                                            <form method="post" action="{{ route('admin.subjects.delete', $subject) }}" data-confirm="Delete this subject?" style="display:inline-block;">
                                                @csrf
                                                @method('delete')
                                                <button class="btn ghost btn-small" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="table-empty" colspan="5">No subjects found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @include('admin.users.partials.pagination', ['paginator' => $subjects])
            </div>
        </section>
    </main>
@endsection
