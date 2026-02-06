@extends('admin.layout')

@section('title', 'Add Lesson')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Topic</p>
                <h1>Add Lesson</h1>
                <p class="subtext">Add lesson content or upload a PDF/video file.</p>
            </div>
            <div class="actions">
                <a class="btn ghost" href="{{ route('admin.topics.lessons.index', $topic) }}">Back to Lessons</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn primary" type="submit">Logout</button>
                </form>
            </div>
        </header>

        <section class="panel">
            <div class="panel-header">
                <h4>Lesson Details</h4>
                <span class="badge gold">Required</span>
            </div>
            <div class="panel-body">
                <form class="form-grid" action="{{ route('admin.topics.lessons.store', $topic) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-field">
                        <label for="title">Title</label>
                        <input id="title" name="title" type="text" value="{{ old('title') }}" required>
                        @error('title')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field form-field-full">
                        <label for="content">Lesson Text (optional)</label>
                        <textarea id="content" name="content" rows="6">{{ old('content') }}</textarea>
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
                    </div>

                    <div class="form-actions">
                        <button class="btn primary" type="submit">Save Lesson</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
