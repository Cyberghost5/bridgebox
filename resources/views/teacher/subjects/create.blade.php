@extends('teacher.layout')

@section('title', 'Create Subject')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Teacher</p>
                <h1>Create Subject</h1>
                <p class="subtext">Add a subject to your section.</p>
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
                <form class="form-grid" action="{{ route('teacher.subjects.store') }}" method="post">
                    @csrf
                    <div class="form-field">
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="section_id">Section</label>
                        <select id="section_id" name="section_id" disabled>
                            @forelse ($sections as $section)
                                <option value="{{ $section->id }}" @selected($selectedSectionId == $section->id)>{{ $section->name }}</option>
                            @empty
                                <option value="">No section assigned</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-field form-field-full">
                        <label for="description">Description (optional)</label>
                        <textarea id="description" name="description">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button class="btn primary" type="submit">Create Subject</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
