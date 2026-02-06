@extends('teacher.layout')

@section('title', ucfirst($type) . 's')

@section('main')
    @php($routePrefix = $type === 'exam' ? 'teacher.exams' : 'teacher.quizzes')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Teacher</p>
                <h1>{{ ucfirst($type) }}s</h1>
                <p class="subtext">Review {{ $type }}s for your classes.</p>
            </div>
            <div class="actions">
                <a class="btn primary" href="{{ route($routePrefix . '.create') }}">Add {{ ucfirst($type) }}</a>
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
                <h4>{{ ucfirst($type) }} List</h4>
                <span class="badge blue">{{ $assessments->total() }}</span>
            </div>
            <div class="panel-body">
                <div class="table-toolbar">
                    <form class="search-form" method="get" action="{{ route($routePrefix . '.index') }}">
                        <input class="search-input" type="text" name="q" placeholder="Search by title" value="{{ $search }}">
                        <button class="btn ghost btn-small" type="submit">Search</button>
                        @if ($search)
                            <a class="btn ghost btn-small" href="{{ route($routePrefix . '.index') }}">Clear</a>
                        @endif
                    </form>
                    <span class="text-muted">Showing {{ $assessments->count() }} of {{ $assessments->total() }}</span>
                </div>

                <div class="table-scroll">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Topic</th>
                                <th>Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($assessments as $index => $assessment)
                                <tr>
                                    <td>{{ $assessments->firstItem() + $index }}</td>
                                    <td>{{ $assessment->title }}</td>
                                    <td>{{ $assessment->schoolClass?->name ?? '-' }}</td>
                                    <td>{{ $assessment->subject?->name ?? '-' }}</td>
                                    <td>{{ $assessment->topic?->title ?? '-' }}</td>
                                    <td>{{ $assessment->time_limit_minutes ? $assessment->time_limit_minutes . ' min' : '-' }}</td>
                                    <td>
                                        <div class="table-actions">
                                            <a class="btn ghost btn-small" href="{{ route($routePrefix . '.questions.index', $assessment) }}">Questions</a>
                                            <a class="btn ghost btn-small" href="{{ route($routePrefix . '.edit', $assessment) }}">Edit</a>
                                            <form method="post" action="{{ route($routePrefix . '.delete', $assessment) }}" data-confirm="Delete this {{ $type }}?" style="display:inline-block;">
                                                @csrf
                                                @method('delete')
                                                <button class="btn ghost btn-small" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="table-empty" colspan="7">No {{ $type }}s found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @include('admin.users.partials.pagination', ['paginator' => $assessments])
            </div>
        </section>
    </main>
@endsection
