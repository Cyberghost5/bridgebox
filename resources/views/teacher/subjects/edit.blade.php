@extends('teacher.layout')

@section('title', 'Edit Subject')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Teacher</p>
                <h1>Edit Subject</h1>
                <p class="subtext">Update subject details for your section.</p>
            </div>
            <div class="actions">
                <a class="btn ghost" href="{{ route('teacher.subjects.index') }}">Back to Subjects</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn primary" type="submit">Logout</button>
                </form>
            </div>
        </header>

        <section class="panel">
            <div class="panel-header">
                <h4>Subject Details</h4>
                <span class="badge gold">Required</span>
            </div>
            <div class="panel-body">
                <form class="form-grid" action="{{ route('teacher.subjects.update', $subject) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-field">
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $subject->name) }}" required>
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="section_id">Section</label>
                        <select id="section_id" name="section_id" disabled>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}" @selected($subject->section_id == $section->id)>{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-field form-field-full">
                        <label for="description">Description (optional)</label>
                        <textarea id="description" name="description">{{ old('description', $subject->description) }}</textarea>
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
