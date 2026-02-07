@extends('student.layout')

@section('title', 'Lesson')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Student</p>
                <h1>{{ $lesson->title }}</h1>
                <p class="subtext">
                    {{ $lesson->topic?->subject?->name ?? 'Subject' }} · {{ $lesson->topic?->title ?? 'Topic' }}
                </p>
            </div>
            <div class="actions">
                <a class="btn ghost" href="{{ route('student.lessons.index') }}">Back to Lessons</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn primary" type="submit">Logout</button>
                </form>
            </div>
        </header>

        <section class="panel">
            <div class="panel-header">
                <h4>Lesson Content</h4>
                <span class="badge gold">Read</span>
            </div>
            <div class="panel-body">
                @if ($lesson->content)
                    <div class="lesson-content">
                        {!! nl2br(e($lesson->content)) !!}
                    </div>
                @else
                    <p class="text-muted">No text content provided for this lesson.</p>
                @endif

                @if ($lesson->file_path)
                    <div class="panel" style="margin-top: 16px;">
                        <div class="panel-header">
                            <h4>Lesson File</h4>
                            <span class="badge blue">{{ $lesson->file_type ?: 'file' }}</span>
                        </div>
                        <div class="panel-body">
                            <div class="table-actions">
                                <a class="btn ghost btn-small" href="{{ route('student.lessons.file', $lesson) }}">Open File</a>
                                <a class="btn ghost btn-small" href="{{ route('student.lessons.file', $lesson) }}" download>Download</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
