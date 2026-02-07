@extends('teacher.layout')

@section('title', 'Edit Question')

@section('main')
    @php($routePrefix = $type === 'exam' ? 'teacher.exams' : 'teacher.quizzes')
    @php($optionA = $options->get(0))
    @php($optionB = $options->get(1))
    @php($optionC = $options->get(2))
    @php($optionD = $options->get(3))
    @php($correctKey = $optionA?->is_correct ? 'a' : ($optionB?->is_correct ? 'b' : ($optionC?->is_correct ? 'c' : ($optionD?->is_correct ? 'd' : null))))
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">{{ ucfirst($type) }}</p>
                <h1>Edit Question</h1>
                <p class="subtext">Update the question for {{ $assessment->title }}.</p>
            </div>
            <div class="actions">
                <a class="btn ghost" href="{{ route($routePrefix . '.questions.index', $assessment) }}">Back to Questions</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn primary" type="submit">Logout</button>
                </form>
            </div>
        </header>

        <section class="panel">
            <div class="panel-header">
                <h4>Question Details</h4>
                <span class="badge gold">Required</span>
            </div>
            <div class="panel-body">
                <form class="form-grid" action="{{ route($routePrefix . '.questions.update', [$assessment, $question]) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-field form-field-full">
                        <label for="prompt">Question</label>
                        <textarea id="prompt" name="prompt" rows="4" required>{{ old('prompt', $question->prompt) }}</textarea>
                        @error('prompt')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="option_a">Option A</label>
                        <input id="option_a" name="option_a" type="text" value="{{ old('option_a', $optionA?->option_text) }}" required>
                        @error('option_a')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-field">
                        <label for="option_b">Option B</label>
                        <input id="option_b" name="option_b" type="text" value="{{ old('option_b', $optionB?->option_text) }}" required>
                        @error('option_b')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-field">
                        <label for="option_c">Option C</label>
                        <input id="option_c" name="option_c" type="text" value="{{ old('option_c', $optionC?->option_text) }}" required>
                        @error('option_c')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-field">
                        <label for="option_d">Option D</label>
                        <input id="option_d" name="option_d" type="text" value="{{ old('option_d', $optionD?->option_text) }}" required>
                        @error('option_d')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label for="correct_option">Correct Answer</label>
                        <select id="correct_option" name="correct_option" required>
                            <option value="" disabled @selected(!old('correct_option', $correctKey))>Select correct option</option>
                            <option value="a" @selected(old('correct_option', $correctKey) === 'a')>Option A</option>
                            <option value="b" @selected(old('correct_option', $correctKey) === 'b')>Option B</option>
                            <option value="c" @selected(old('correct_option', $correctKey) === 'c')>Option C</option>
                            <option value="d" @selected(old('correct_option', $correctKey) === 'd')>Option D</option>
                        </select>
                        @error('correct_option')
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
