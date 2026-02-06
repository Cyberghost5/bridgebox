@extends('admin.layout')

@section('title', 'Create Class')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Admin</p>
                <h1>Create Class</h1>
                <p class="subtext">Create a new class used in the system.</p>
            </div>
            <div class="actions">
                <a class="btn ghost" href="{{ route('admin.classes.index') }}">Back to Classes</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn primary" type="submit">Logout</button>
                </form>
            </div>
        </header>

        <section class="panel">
            <div class="panel-header">
                <h4>Class Details</h4>
                <span class="badge gold">Required</span>
            </div>
            <div class="panel-body">
                <form class="form-grid" action="{{ route('admin.classes.store') }}" method="post">
                    @csrf
                    <div class="form-field">
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required>
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="slug">Slug (optional)</label>
                        <input id="slug" name="slug" type="text" value="{{ old('slug') }}">
                        @error('slug')
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
                        <button class="btn primary" type="submit">Create Class</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
