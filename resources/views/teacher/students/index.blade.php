@extends('teacher.layout')

@section('title', 'Students')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Teacher</p>
                <h1>Students</h1>
                <p class="subtext">View students assigned to your classes.</p>
            </div>
            <div class="actions">
                <a class="btn primary" href="{{ route('teacher.students.create') }}">Add Student</a>
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

        @if (!($teacherClass?->id))
            <div class="alert alert-error" role="status">
                <span data-alert-message>Your account has no class assigned. Students will not appear until a class is assigned.</span>
            </div>
        @endif

        <section class="panel table-panel">
            <div class="panel-header">
                <h4>Students List</h4>
                <span class="badge blue">{{ $students->total() }}</span>
            </div>
            <div class="panel-body">
                <div class="table-toolbar">
                    @php($hasFilters = $search || $selectedClassId || $selectedDepartment)
                    <form class="search-form" method="get" action="{{ route('teacher.students.index') }}">
                        <input class="search-input" type="text" name="q" placeholder="Search by name or email" value="{{ $search }}">
                        <select class="search-input" name="department">
                            <option value="" @selected(!$selectedDepartment)>All departments</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department }}" @selected($selectedDepartment === $department)>{{ $department }}</option>
                            @endforeach
                        </select>
                        <button class="btn ghost btn-small" type="submit">Filter</button>
                        @if ($hasFilters)
                            <a class="btn ghost btn-small" href="{{ route('teacher.students.index') }}">Clear</a>
                        @endif
                    </form>
                    <span class="text-muted">Showing {{ $students->count() }} of {{ $students->total() }}</span>
                </div>

                <div class="table-scroll">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Class</th>
                                <th>Department</th>
                                <th>Admission ID</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr class="row-link" data-row-href="{{ route('teacher.students.show', $student) }}" tabindex="0" role="link" aria-label="View {{ $student->name }}">
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->schoolClass?->name ?? $student->studentProfile?->class ?? '-' }}</td>
                                    <td>{{ $student->studentProfile?->department ?? '-' }}</td>
                                    <td>{{ $student->studentProfile?->admission_id ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $student->is_active ? 'green' : 'rose' }}">
                                            {{ $student->is_active ? 'Active' : 'Disabled' }}
                                        </span>
                                    </td>
                                    <td>{{ $student->created_at?->format('Y-m-d') ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="table-empty" colspan="7">No students found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @include('admin.users.partials.pagination', ['paginator' => $students])
            </div>
        </section>
    </main>
@endsection
