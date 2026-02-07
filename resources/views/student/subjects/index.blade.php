@extends('student.layout')

@section('title', 'Subjects')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Student</p>
                <h1>Subjects</h1>
                <p class="subtext">Browse subjects for your class.</p>
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
                <span data-alert-message>Your account has no class assigned. Subjects will not appear until a class is assigned.</span>
            </div>
        @endif

        <section class="panel table-panel">
            <div class="panel-header">
                <h4>Subjects List</h4>
                <span class="badge blue">{{ $subjects->total() }}</span>
            </div>
            <div class="panel-body">
                <div class="table-toolbar">
                    <form class="search-form" method="get" action="{{ route('student.subjects.index') }}">
                        <input class="search-input" type="text" name="q" placeholder="Search by name or code" value="{{ $search }}">
                        <button class="btn ghost btn-small" type="submit">Search</button>
                        @if ($search)
                            <a class="btn ghost btn-small" href="{{ route('student.subjects.index') }}">Clear</a>
                        @endif
                    </form>
                    <span class="text-muted">Showing {{ $subjects->count() }} of {{ $subjects->total() }}</span>
                </div>

                <div class="table-scroll">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>Code</th>
                                <th>Topics</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subjects as $index => $subject)
                                <tr>
                                    <td>{{ $subjects->firstItem() + $index }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->code ?: '-' }}</td>
                                    <td>{{ $subject->topics_count ?? 0 }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="table-empty" colspan="4">No subjects found.</td>
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
