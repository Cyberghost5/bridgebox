@extends('admin.layout')

@section('title', 'Edit Student')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Admin User Management</p>
                <h1>Edit Student</h1>
                <p class="subtext">Update student account details.</p>
            </div>
            <div class="actions">
                <a class="btn ghost" href="{{ route('admin.users.students.index') }}">Back to Students</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn primary" type="submit">Logout</button>
                </form>
            </div>
        </header>

        <section class="panel">
            <div class="panel-header">
                <h4>Student Details</h4>
                <span class="badge gold">Required</span>
            </div>
            <div class="panel-body">
                <form class="form-grid" action="{{ route('admin.users.students.update', $student) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-field">
                        <label for="name">Full name</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $student->name) }}" required>
                        @error('name')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-field">
                        <label for="email">Email address</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $student->email) }}" required>
                        @error('email')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-field">
                        <label for="phone">Phone (optional)</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone', $student->phone) }}">
                        @error('phone')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-field">
                        <label for="school_class_id">Class</label>
                        <select id="school_class_id" name="school_class_id" required>
                            <option value="" disabled>Select a class</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" @selected(old('school_class_id', $student->school_class_id) == $class->id)>{{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('school_class_id')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-field">
                        <label for="department">Department (optional)</label>
                        <input id="department" name="department" type="text" value="{{ old('department', $student->studentProfile?->department) }}">
                        @error('department')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-field">
                        <label for="admission_id">Admission ID (optional)</label>
                        <input id="admission_id" name="admission_id" type="text" value="{{ old('admission_id', $student->studentProfile?->admission_id) }}">
                        @error('admission_id')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="password">New password (optional)</label>
                        <input id="password" name="password" type="password" autocomplete="new-password">
                        @error('password')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-field">
                        <label for="password_confirmation">Confirm new password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
                    </div>

                    <div class="form-actions">
                        <button class="btn primary" type="submit">Save Changes</button>
                    </div>
                </form>
            </div>
        </section>
    </main>
@endsection
