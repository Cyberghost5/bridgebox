@extends('admin.layout')

@section('title', 'Topic Lessons')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Topic</p>
                <h1>{{ $topic->title }}</h1>
                <p class="subtext">Lessons stored offline for this topic.</p>
            </div>
            <div class="actions">
                <a class="btn primary" href="{{ route('admin.topics.lessons.create', $topic) }}">Add Lesson</a>
                <a class="btn ghost" href="{{ route('admin.topics.index') }}">Back to Topics</a>
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
                <h4>Lessons</h4>
                <span class="badge blue">{{ $lessons->total() }}</span>
            </div>
            <div class="panel-body">
                <div class="table-toolbar">
                    <span class="text-muted">Showing {{ $lessons->count() }} of {{ $lessons->total() }}</span>
                </div>

                <div class="table-scroll">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Text</th>
                                <th>File</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lessons as $index => $lesson)
                                <tr>
                                    <td>{{ $lessons->firstItem() + $index }}</td>
                                    <td>{{ $lesson->title }}</td>
                                    <td>{{ $lesson->content ? Str::limit($lesson->content, 60) : '-' }}</td>
                                    <td>{{ $lesson->file_name ?: '-' }}</td>
                                    <td>{{ $lesson->created_at?->format('Y-m-d') ?? '-' }}</td>
                                    <td>
                                        <div class="table-actions">
                                            @if ($lesson->file_path)
                                                <a class="btn ghost btn-small" href="{{ route('admin.topics.lessons.download', [$topic, $lesson]) }}">Download</a>
                                            @endif
                                            <a class="btn ghost btn-small" href="{{ route('admin.assignments.create', ['lesson_id' => $lesson->id]) }}">Assignments</a>
                                            <form method="post" action="{{ route('admin.topics.lessons.delete', [$topic, $lesson]) }}" data-confirm="Delete this lesson?" style="display:inline-block;">
                                                @csrf
                                                @method('delete')
                                                <button class="btn ghost btn-small" type="submit">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="table-empty" colspan="6">No lessons found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @include('admin.users.partials.pagination', ['paginator' => $lessons])
            </div>
        </section>
    </main>
@endsection
