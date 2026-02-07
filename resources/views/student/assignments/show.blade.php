@extends('student.layout')

@section('title', 'Assignment')

@section('main')
        <main class="main">
            <header class="topbar">
                <div class="greeting">
                    <p class="eyebrow">Assignment</p>
                    <h1>{{ $assignment->title }}</h1>
                    <p class="subtext">Lesson: {{ $assignment->lesson?->title ?? '-' }}</p>
                </div>
                <div class="actions">
                    <a class="btn ghost" href="{{ route('student.assignments.index') }}">Back to Assignments</a>
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
                    <h4>Submit Assignment</h4>
                    <span class="badge gold">Required</span>
                </div>
                <div class="panel-body">
                    <div class="item-list" style="display:flex;flex-direction:column;gap:6px;margin-bottom:16px;">
                        <div class="item">
                            <div class="item-info">
                                <p>Subject</p>
                                <span>{{ $assignment->lesson?->topic?->subject?->name ?? '-' }}</span>
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
                                <p>Deadline</p>
                                <span>{{ $assignment->due_at?->format('Y-m-d H:i') ?? '-' }}</span>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-info">
                                <p>Pass Mark</p>
                                <span>{{ $assignment->pass_mark ?? '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <form class="form-grid" action="{{ route('student.assignments.submit', $assignment) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-field form-field-full">
                            <label for="content">Your Answer (optional)</label>
                            <textarea id="content" name="content" rows="6">{{ old('content', $submission?->content) }}</textarea>
                            @error('content')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label for="file">Upload File (PDF or video)</label>
                            <input id="file" name="file" type="file" accept="application/pdf,video/mp4,video/webm,video/ogg">
                            @error('file')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                            @if ($submission?->file_name)
                                <div class="text-muted" style="margin-top:6px;">Current file: {{ $submission->file_name }}</div>
                            @endif
                        </div>

                        <div class="form-actions">
                            <button class="btn primary" type="submit">Submit Assignment</button>
                        </div>
                    </form>

                    @if ($submission)
                        <div class="panel" style="margin-top: 16px;">
                            <div class="panel-header">
                                <h4>Last Submission</h4>
                                <span class="badge blue">{{ $submission->submitted_at?->format('Y-m-d H:i') ?? '-' }}</span>
                            </div>
                            <div class="panel-body">
                                <div class="item">
                                    <div class="item-info">
                                        <p>Status</p>
                                        <span>{{ $submission->status ?? 'submitted' }}</span>
                                    </div>
                                </div>
                                @if ($submission->file_name)
                                    <div class="item">
                                        <div class="item-info">
                                            <p>File</p>
                                            <span>{{ $submission->file_name }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </main>
@endsection
