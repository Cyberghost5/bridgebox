@extends('admin.layout')

@section('title', 'Edit Assignment')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Admin</p>
                <h1>Edit Assignment</h1>
                <p class="subtext">Update assignment details.</p>
            </div>
            <div class="actions">
                <a class="btn ghost" href="{{ route('admin.assignments.index') }}">Back to Assignments</a>
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
                <form class="form-grid" action="{{ route('admin.assignments.update', $assignment) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-field">
                        <label for="title">Title</label>
                        <input id="title" name="title" type="text" value="{{ old('title', $assignment->title) }}" required>
                        @error('title')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="lesson_id">Lesson</label>
                        <select id="lesson_id" name="lesson_id" required>
                            <option value="" disabled>Select a lesson</option>
                            @foreach ($lessons as $lesson)
                                <option value="{{ $lesson->id }}" @selected(old('lesson_id', $assignment->lesson_id) == $lesson->id)>
                                    {{ $lesson->title }}{{ $lesson->topic ? ' — ' . $lesson->topic->title : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('lesson_id')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="due_at">Deadline</label>
                        <input id="due_at" name="due_at" type="datetime-local" value="{{ old('due_at', $assignment->due_at?->format('Y-m-d\TH:i')) }}" required>
                        @error('due_at')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="max_points">Total Mark</label>
                        <input id="max_points" name="max_points" type="number" min="1" max="1000" value="{{ old('max_points', $assignment->max_points) }}" required>
                        @error('max_points')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="pass_mark">Pass Mark</label>
                        <input id="pass_mark" name="pass_mark" type="number" min="0" max="1000" value="{{ old('pass_mark', $assignment->pass_mark) }}" required>
                        @error('pass_mark')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="retake_attempts">Retake attempts</label>
                        <input id="retake_attempts" name="retake_attempts" type="number" min="0" max="100" value="{{ old('retake_attempts', $assignment->retake_attempts) }}" required>
                        @error('retake_attempts')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field form-field-full">
                        <label class="checkbox">
                            <input type="checkbox" name="allow_late" value="1" {{ old('allow_late', $assignment->allow_late) ? 'checked' : '' }}>
                            <span>Allow late submission</span>
                        </label>
                    </div>

                    <div class="form-field" data-late-fields>
                        <label for="late_mark">Late submission mark</label>
                        <input id="late_mark" name="late_mark" type="number" min="0" max="1000" value="{{ old('late_mark', $assignment->late_mark) }}">
                        @error('late_mark')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field" data-late-fields>
                        <label for="late_due_at">Late submission deadline</label>
                        <input id="late_due_at" name="late_due_at" type="datetime-local" value="{{ old('late_due_at', $assignment->late_due_at?->format('Y-m-d\TH:i')) }}">
                        @error('late_due_at')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field form-field-full">
                        <label for="description">Assignment description</label>
                        <textarea id="description" name="description" required>{{ old('description', $assignment->description) }}</textarea>
                        @error('description')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button class="btn primary" type="submit">Save Changes</button>
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
