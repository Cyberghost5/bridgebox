@extends('teacher.layout')

@section('title', 'Teacher Dashboard')

@section('main')
    <main class="main teacher-dashboard">
        <section class="teacher-hero">
            <div class="teacher-hero-content">
                <p class="eyebrow">Teacher Console</p>
                <h1>Welcome back, {{ auth()->user()->name ?? 'Teacher' }}.</h1>
                <p class="subtext">Manage students, lessons, and assessments with clear visibility.</p>

                <div class="teacher-hero-actions">
                    <a class="btn primary" href="{{ route('teacher.assignments.create') }}">New Assignment</a>
                    <a class="btn ghost" href="{{ route('teacher.quizzes.create') }}">New Quiz</a>
                    <a class="btn ghost" href="{{ route('teacher.exams.create') }}">New Exam</a>
                    <a class="btn ghost" href="{{ route('teacher.topics.create') }}">Add Topic</a>
                </div>
            </div>
            <div class="teacher-hero-panel">
                <div class="teacher-class-card">
                    <div>
                        <p class="teacher-class-label">Assigned Class</p>
                        <h3>{{ $teacherClass?->name ?? 'No class assigned' }}</h3>
                        <p class="teacher-class-meta">
                            {{ $teacherClass?->description ?: 'Assign a class to unlock student lists and class-specific content.' }}
                        </p>
                    </div>
                    <div class="teacher-class-stats">
                        <div>
                            <span>Students</span>
                            <strong>{{ $stats['students'] }}</strong>
                        </div>
                        <div>
                            <span>Topics</span>
                            <strong>{{ $stats['topics'] }}</strong>
                        </div>
                        <div>
                            <span>Assignments</span>
                            <strong>{{ $stats['assignments'] }}</strong>
                        </div>
                    </div>
                    <a class="btn ghost btn-small" href="{{ route('teacher.students.index') }}">View Students</a>
                </div>
            </div>
        </section>

        <section class="teacher-metrics">
            <a class="metric-card" href="{{ route('teacher.students.index') }}">
                <p>Students</p>
                <h2>{{ $stats['students'] }}</h2>
                <span>In your class</span>
            </a>
            <a class="metric-card" href="{{ route('teacher.classes.index') }}">
                <p>Classes</p>
                <h2>{{ $stats['classes'] }}</h2>
                <span>Assigned</span>
            </a>
            <a class="metric-card" href="{{ route('teacher.subjects.index') }}">
                <p>Subjects</p>
                <h2>{{ $stats['subjects'] }}</h2>
                <span>Total available</span>
            </a>
            <a class="metric-card" href="{{ route('teacher.topics.index') }}">
                <p>Topics</p>
                <h2>{{ $stats['topics'] }}</h2>
                <span>For your class</span>
            </a>
            <a class="metric-card" href="{{ route('teacher.assignments.index') }}">
                <p>Assignments</p>
                <h2>{{ $stats['assignments'] }}</h2>
                <span>Active</span>
            </a>
            <a class="metric-card" href="{{ route('teacher.quizzes.index') }}">
                <p>Quizzes</p>
                <h2>{{ $stats['quizzes'] }}</h2>
                <span>Ready</span>
            </a>
            <a class="metric-card" href="{{ route('teacher.exams.index') }}">
                <p>Exams</p>
                <h2>{{ $stats['exams'] }}</h2>
                <span>Scheduled</span>
            </a>
        </section>

        <section class="teacher-lanes">
            <div class="panel teacher-panel">
                <div class="panel-header">
                    <h4>Recent Assignments</h4>
                    <a class="btn ghost btn-small" href="{{ route('teacher.assignments.index') }}">View all</a>
                </div>
                <div class="panel-body">
                    @forelse ($recentAssignments as $assignment)
                        <div class="teacher-item">
                            <div>
                                <p>{{ $assignment->title }}</p>
                                <span>{{ $assignment->lesson?->topic?->title ?? 'No topic' }}</span>
                            </div>
                            <div class="teacher-item-meta">
                                <span>Due</span>
                                <strong>{{ $assignment->due_at?->format('M d') ?? '-' }}</strong>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No assignments yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="panel teacher-panel">
                <div class="panel-header">
                    <h4>Recent Quizzes & Exams</h4>
                    <a class="btn ghost btn-small" href="{{ route('teacher.quizzes.index') }}">View all</a>
                </div>
                <div class="panel-body">
                    @forelse ($recentAssessments as $assessment)
                        <div class="teacher-item">
                            <div>
                                <p>{{ $assessment->title }}</p>
                                <span>{{ ucfirst($assessment->type) }} • {{ $assessment->subject?->name ?? 'No subject' }}</span>
                            </div>
                            <div class="teacher-item-meta">
                                <span>Time</span>
                                <strong>{{ $assessment->time_limit_minutes ? $assessment->time_limit_minutes . 'm' : '-' }}</strong>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No assessments yet.</p>
                    @endforelse
                </div>
            </div>

            <div class="panel teacher-panel teacher-panel-wide">
                <div class="panel-header">
                    <h4>Quick Access</h4>
                    <span class="badge blue">Manage</span>
                </div>
                <div class="panel-body teacher-quick-grid">
                    <a class="teacher-quick-card" href="{{ route('teacher.students.index') }}">
                        <div>
                            <p>Students</p>
                            <span>Manage class roster</span>
                        </div>
                        <i class="fa-solid fa-user-graduate" aria-hidden="true"></i>
                    </a>
                    <a class="teacher-quick-card" href="{{ route('teacher.topics.index') }}">
                        <div>
                            <p>Topics</p>
                            <span>Organize learning units</span>
                        </div>
                        <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                    </a>
                    <a class="teacher-quick-card" href="{{ route('teacher.assignments.index') }}">
                        <div>
                            <p>Assignments</p>
                            <span>Track submissions</span>
                        </div>
                        <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                    </a>
                    <a class="teacher-quick-card" href="{{ route('teacher.quizzes.index') }}">
                        <div>
                            <p>Quizzes</p>
                            <span>Build quick checks</span>
                        </div>
                        <i class="fa-solid fa-circle-question" aria-hidden="true"></i>
                    </a>
                    <a class="teacher-quick-card" href="{{ route('teacher.exams.index') }}">
                        <div>
                            <p>Exams</p>
                            <span>Formal evaluations</span>
                        </div>
                        <i class="fa-solid fa-clipboard-check" aria-hidden="true"></i>
                    </a>
                    <a class="teacher-quick-card" href="{{ route('teacher.subjects.index') }}">
                        <div>
                            <p>Subjects</p>
                            <span>Curriculum catalog</span>
                        </div>
                        <i class="fa-solid fa-book" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </section>
    </main>
@endsection
