@extends('student.layout')

@section('title', 'Student Dashboard')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Student Hub</p>
                <h1>Keep going, {{ $student?->name ?? 'Student' }}.</h1>
                <p class="subtext">Pick up where you left off and track your progress.</p>
            </div>
            <div class="actions">
                <button class="btn ghost" type="button">Resume Lesson</button>
                <a class="btn primary" href="{{ route('dashboard.student') }}">Refresh</a>
            </div>
        </header>

        <section class="quick-tabs">
            <div class="tab" style="--accent: #4a7bd1; --d: 0.05s;">
                <div class="tab-icon">
                    <i class="fa-solid fa-book-open" aria-hidden="true"></i>
                </div>
                <div>
                    <p>Lessons Ready</p>
                    <span>{{ $lessonsCount ?? 0 }} available</span>
                </div>
            </div>
            <div class="tab" style="--accent: #e56b6f; --d: 0.1s;">
                <div class="tab-icon">
                    <i class="fa-solid fa-circle-question" aria-hidden="true"></i>
                </div>
                <div>
                    <p>Quizzes</p>
                    <span>{{ $quizzesCount ?? 0 }} available</span>
                </div>
            </div>
            <div class="tab" style="--accent: #f2b84b; --d: 0.15s;">
                <div class="tab-icon">
                    <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                </div>
                <div>
                    <p>Assignments</p>
                    <span>{{ $assignmentsCount ?? 0 }} available</span>
                </div>
            </div>
            <div class="tab" style="--accent: #56c1a7; --d: 0.2s;">
                <div class="tab-icon">
                    <i class="fa-solid fa-clipboard-check" aria-hidden="true"></i>
                </div>
                <div>
                    <p>Exams</p>
                    <span>{{ $examsCount ?? 0 }} available</span>
                </div>
            </div>
        </section>

        <section class="panel table-panel">
            <div class="panel-header">
                <h4>Class Overview</h4>
                <span class="badge coral">Class</span>
            </div>
            <div class="panel-body table-scroll">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Topics</th>
                            <th>Lessons</th>
                            <th>Quizzes</th>
                            <th>Exams</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>All Subjects</td>
                            <td>{{ $topicsCount ?? 0 }}</td>
                            <td>{{ $lessonsCount ?? 0 }}</td>
                            <td>{{ $quizzesCount ?? 0 }}</td>
                            <td>{{ $examsCount ?? 0 }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
@endsection
