@extends('teacher.layout')

@section('title', 'Grade Submission')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Teacher</p>
                <h1>{{ $submission->user?->name ?? 'Student' }} - {{ $assignment->title }}</h1>
                <p class="subtext">Review and grade the submission.</p>
            </div>
            <div class="actions">
                <a class="btn ghost" href="{{ route('teacher.assignments.submissions.index', $assignment) }}">Back to Submissions</a>
                @if ($submission->file_path)
                    <a class="btn ghost" href="{{ route('teacher.assignments.submissions.download', [$assignment, $submission]) }}">Download File</a>
                @endif
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

        <section class="panel">
            <div class="panel-header">
                <h4>Submission Summary</h4>
                <span class="badge {{ ($submission->status ?? '') === 'graded' ? 'green' : 'blue' }}">{{ $submission->status ?? 'pending' }}</span>
            </div>
            <div class="panel-body">
                <div class="item-list" style="display:flex;flex-direction:column;gap:6px;">
                    <div class="item">
                        <div class="item-info">
                            <p>Student</p>
                            <span>{{ $submission->user?->name ?? 'Unknown' }}</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-info">
                            <p>Submitted</p>
                            <span>{{ $submission->submitted_at?->format('Y-m-d H:i') ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-info">
                            <p>Lesson</p>
                            <span>{{ $assignment->lesson?->title ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-info">
                            <p>Topic</p>
                            <span>{{ $assignment->lesson?->topic?->title ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-info">
                            <p>Score</p>
                            <span>
                                @if ($submission->score !== null)
                                    {{ $submission->score }}{{ $assignment->max_points ? ' / ' . $assignment->max_points : '' }}
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                    </div>
                    @if ($assignment->max_points)
                        <div class="item">
                            <div class="item-info">
                                <p>Total Mark</p>
                                <span>{{ $assignment->max_points }}</span>
                            </div>
                        </div>
                    @endif
                    @if ($assignment->pass_mark !== null)
                        <div class="item">
                            <div class="item-info">
                                <p>Pass Mark</p>
                                <span>{{ $assignment->pass_mark }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <section class="panel">
            <div class="panel-header">
                <h4>Student Response</h4>
                <span class="badge blue">Submission</span>
            </div>
            <div class="panel-body">
                <div class="item-list" style="display:flex;flex-direction:column;gap:12px;">
                    <div class="item">
                        <div class="item-info">
                            <p>Text</p>
                            <span>{{ $submission->content ?: '-' }}</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-info">
                            <p>File</p>
                            <span>{{ $submission->file_name ?: '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel">
            <div class="panel-header">
                <h4>Grade Submission</h4>
                <span class="badge gold">Optional</span>
            </div>
            <div class="panel-body">
                <form class="form-grid" action="{{ route('teacher.assignments.submissions.update', [$assignment, $submission]) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-field">
                        <label for="score">Score</label>
                        <input id="score" name="score" type="number" min="0" @if ($assignment->max_points) max="{{ $assignment->max_points }}" @endif value="{{ old('score', $submission->score) }}">
                        @if ($assignment->max_points)
                            <small class="text-muted">Max {{ $assignment->max_points }}</small>
                        @endif
                        @error('score')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field form-field-full">
                        <label for="feedback">Feedback</label>
                        <textarea id="feedback" name="feedback" rows="4">{{ old('feedback', $submission->feedback) }}</textarea>
                        @error('feedback')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button class="btn primary" type="submit">Save Grade</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
