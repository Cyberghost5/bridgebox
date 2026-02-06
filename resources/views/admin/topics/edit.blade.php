@extends('admin.layout')

@section('title', 'Edit Topic')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Admin</p>
                <h1>Edit Topic</h1>
                <p class="subtext">Update topic details.</p>
            </div>
            <div class="actions">
                <a class="btn ghost" href="{{ route('admin.topics.index') }}">Back to Topics</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn primary" type="submit">Logout</button>
                </form>
            </div>
        </header>

        <section class="panel">
            <div class="panel-header">
                <h4>Topic Details</h4>
                <span class="badge gold">Required</span>
            </div>
            <div class="panel-body">
                <form class="form-grid" action="{{ route('admin.topics.update', $topic) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-field">
                        <label for="title">Title</label>
                        <input id="title" name="title" type="text" value="{{ old('title', $topic->title) }}" required>
                        @error('title')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="school_class_id">Class</label>
                        <select id="school_class_id" name="school_class_id" required>
                            <option value="" disabled>Select a class</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" @selected(old('school_class_id', $topic->school_class_id) == $class->id)>{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('school_class_id')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="subject_id">Subject</label>
                        <select id="subject_id" name="subject_id" required>
                            <option value="" disabled>Select a subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" @selected(old('subject_id', $topic->subject_id) == $subject->id)>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field form-field-full">
                        <label for="description">Description (optional)</label>
                        <textarea id="description" name="description">{{ old('description', $topic->description) }}</textarea>
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
