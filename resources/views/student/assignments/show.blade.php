<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Assignment | BridgeBox</title>
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
</head>
<body>
    <div class="page">
        <main class="main">
            <header class="topbar">
                <div class="greeting">
                    <p class="eyebrow">Assignment</p>
                    <h1>{{ $assignment->title }}</h1>
                    <p class="subtext">Lesson: {{ $assignment->lesson?->title ?? '-' }}</p>
                </div>
                <div class="actions">
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
                </div>
            </section>
        </main>
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
</body>
</html>
