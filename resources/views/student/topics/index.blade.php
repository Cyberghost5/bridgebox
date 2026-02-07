@extends('student.layout')

@section('title', 'Topics')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Student</p>
                <h1>Topics</h1>
                <p class="subtext">Browse topics by subject for your class.</p>
            </div>
            <div class="actions">
                <a class="btn ghost" href="{{ route('dashboard.student') }}">Back to Dashboard</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn primary" type="submit">Logout</button>
                </form>
            </div>
        </header>

        @if (!($student?->school_class_id))
            <div class="alert alert-error" role="status">
                <span data-alert-message>Your account has no class assigned. Topics will not appear until a class is assigned.</span>
            </div>
        @endif

        <section class="panel table-panel">
            <div class="panel-header">
                <h4>Topics List</h4>
                <span class="badge blue">{{ $topics->total() }}</span>
            </div>
            <div class="panel-body">
                <div class="table-toolbar">
                    @php($hasFilters = $search || $selectedSubjectId)
                    <form class="search-form" method="get" action="{{ route('student.topics.index') }}">
                        <input class="search-input" type="text" name="q" placeholder="Search by title" value="{{ $search }}">
                        <select class="search-input" name="subject_id">
                            <option value="" @selected(!$selectedSubjectId)>All subjects</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" @selected($selectedSubjectId == $subject->id)>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn ghost btn-small" type="submit">Filter</button>
                        @if ($hasFilters)
                            <a class="btn ghost btn-small" href="{{ route('student.topics.index') }}">Clear</a>
                        @endif
                    </form>
                    <span class="text-muted">Showing {{ $topics->count() }} of {{ $topics->total() }}</span>
                </div>

                <div class="table-scroll">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Topic</th>
                                <th>Subject</th>
                                <th>Lessons</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($topics as $index => $topic)
                                <tr>
                                    <td>{{ $topics->firstItem() + $index }}</td>
                                    <td>{{ $topic->title }}</td>
                                    <td>{{ $topic->subject?->name ?? '-' }}</td>
                                    <td>{{ $topic->lessons_count ?? 0 }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="table-empty" colspan="4">No topics found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @include('admin.users.partials.pagination', ['paginator' => $topics])
            </div>
        </section>
    </main>
@endsection
