@extends('teacher.layout')

@section('title', 'Create Assignment')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Teacher</p>
                <h1>Create Assignment</h1>
                <p class="subtext">Create an assignment based on a lesson.</p>
            </div>
            <div class="actions">
                <a class="btn ghost" href="{{ route('teacher.assignments.index') }}">Back to Assignments</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn primary" type="submit">Logout</button>
                </form>
            </div>
        </header>

        <section class="panel">
            <div class="panel-header">
                <h4>Assignment Details</h4>
                <span class="badge gold">Required</span>
            </div>
            <div class="panel-body">
                <form class="form-grid" action="{{ route('teacher.assignments.store') }}" method="post">
                    @csrf
                    <div class="form-field">
                        <label for="title">Title</label>
                        <input id="title" name="title" type="text" value="{{ old('title') }}" required>
                        @error('title')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="lesson_id">Lesson</label>
                        <select id="lesson_id" name="lesson_id" required>
                            <option value="" disabled @selected(!old('lesson_id', request('lesson_id')))>Select a lesson</option>
                            @foreach ($lessons as $lesson)
                                <option value="{{ $lesson->id }}" @selected(old('lesson_id', request('lesson_id')) == $lesson->id)>
                                    {{ $lesson->title }}{{ $lesson->topic ? ' � ' . $lesson->topic->title : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('lesson_id')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="due_at">Deadline</label>
                        <input id="due_at" name="due_at" type="datetime-local" value="{{ old('due_at') }}" required>
                        @error('due_at')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="max_points">Total Mark</label>
                        <input id="max_points" name="max_points" type="number" min="1" max="1000" value="{{ old('max_points') }}" required>
                        @error('max_points')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="pass_mark">Pass Mark</label>
                        <input id="pass_mark" name="pass_mark" type="number" min="0" max="1000" value="{{ old('pass_mark') }}" required>
                        @error('pass_mark')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="retake_attempts">Retake attempts</label>
                        <input id="retake_attempts" name="retake_attempts" type="number" min="0" max="100" value="{{ old('retake_attempts', 0) }}" required>
                        @error('retake_attempts')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field form-field-full">
                        <label for="description">Assignment description</label>
                        <textarea id="description" name="description" required>{{ old('description') }}</textarea>
                        @error('description')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field form-field-full">
                        <label class="checkbox">
                            <input type="checkbox" name="allow_late" value="1" {{ old('allow_late') ? 'checked' : '' }}>
                            <span>Allow late submission</span>
                        </label>
                    </div>

                    <div class="form-field" data-late-fields>
                        <label for="late_mark">Late submission mark</label>
                        <input id="late_mark" name="late_mark" type="number" min="0" max="1000" value="{{ old('late_mark') }}">
                        @error('late_mark')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field" data-late-fields>
                        <label for="late_due_at">Late submission deadline</label>
                        <input id="late_due_at" name="late_due_at" type="datetime-local" value="{{ old('late_due_at') }}">
                        @error('late_due_at')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button class="btn primary" type="submit">Create Assignment</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        const allowLate = document.querySelector('input[name="allow_late"]');
        const lateFields = document.querySelectorAll('[data-late-fields]');
        const lateMark = document.getElementById('late_mark');
        const lateDue = document.getElementById('late_due_at');
        const toggleLateFields = () => {
            const enabled = allowLate && allowLate.checked;
            lateFields.forEach((field) => {
                field.style.display = enabled ? '' : 'none';
            });
            if (lateMark) {
                lateMark.required = enabled;
            }
            if (lateDue) {
                lateDue.required = enabled;
            }
        };
        if (allowLate) {
            allowLate.addEventListener('change', toggleLateFields);
            toggleLateFields();
        }
    </script>
@endpush
