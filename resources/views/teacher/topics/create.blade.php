@extends('teacher.layout')

@section('title', 'Create Topic')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Teacher</p>
                <h1>Create Topic</h1>
                <p class="subtext">Add a topic tied to a class and subject.</p>
            </div>
            <div class="actions">
                <a class="btn ghost" href="{{ route('teacher.topics.index') }}">Back to Topics</a>
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
                <form class="form-grid" action="{{ route('teacher.topics.store') }}" method="post">
                    @csrf
                    <div class="form-field">
                        <label for="title">Title</label>
                        <input id="title" name="title" type="text" value="{{ old('title') }}" required>
                        @error('title')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="school_class_id">Class</label>
                        <select id="school_class_id" name="school_class_id" required>
                            <option value="" disabled @selected(!old('school_class_id'))>Select a class</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" @selected(old('school_class_id') == $class->id)>{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('school_class_id')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="subject_id">Subject</label>
                        <select id="subject_id" name="subject_id" required>
                            <option value="" disabled @selected(!old('subject_id'))>Select a subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" @selected(old('subject_id') == $subject->id)>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        @error('subject_id')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field form-field-full">
                        <label for="description">Description (optional)</label>
                        <textarea id="description" name="description">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button class="btn primary" type="submit">Create Topic</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
