@extends('student.layout')

@section('title', 'Lessons')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Student</p>
                <h1>Lessons</h1>
                <p class="subtext">Read or download lessons for your class.</p>
            </div>
            <div class="actions">
                <a class="btn ghost" href="{{ route('dashboard.student') }}">Back to Dashboard</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn primary" type="submit">Logout</button>
                </form>
            </div>
        </header>

        @if (!($student?->school_class_id))
            <div class="alert alert-error" role="status">
                <span data-alert-message>Your account has no class assigned. Lessons will not appear until a class is assigned.</span>
            </div>
        @endif

        <section class="panel table-panel">
            <div class="panel-header">
                <h4>Lessons List</h4>
                <span class="badge blue">{{ $lessons->total() }}</span>
            </div>
            <div class="panel-body">
                <div class="table-toolbar">
                    @php($hasFilters = $search || $selectedSubjectId || $selectedTopicId)
                    <form class="search-form" method="get" action="{{ route('student.lessons.index') }}">
                        <input class="search-input" type="text" name="q" placeholder="Search by title" value="{{ $search }}">
                        <select class="search-input" name="subject_id" id="subject_id">
                            <option value="" @selected(!$selectedSubjectId)>All subjects</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" @selected($selectedSubjectId == $subject->id)>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                        <select class="search-input" name="topic_id" id="topic_id" data-topics-url="{{ route('student.topics.by-subject') }}" data-selected-topic="{{ $selectedTopicId }}">
                            <option value="" @selected(!$selectedTopicId)>All topics</option>
                            @foreach ($topics as $topic)
                                <option value="{{ $topic->id }}" @selected($selectedTopicId == $topic->id)>{{ $topic->title }}</option>
                            @endforeach
                        </select>
                        <button class="btn ghost btn-small" type="submit">Filter</button>
                        @if ($hasFilters)
                            <a class="btn ghost btn-small" href="{{ route('student.lessons.index') }}">Clear</a>
                        @endif
                    </form>
                    <span class="text-muted">Showing {{ $lessons->count() }} of {{ $lessons->total() }}</span>
                </div>

                <div class="table-scroll">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Lesson</th>
                                <th>Topic</th>
                                <th>Subject</th>
                                <th>Content</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lessons as $index => $lesson)
                                <tr>
                                    <td>{{ $lessons->firstItem() + $index }}</td>
                                    <td>{{ $lesson->title }}</td>
                                    <td>{{ $lesson->topic?->title ?? '-' }}</td>
                                    <td>{{ $lesson->topic?->subject?->name ?? '-' }}</td>
                                    <td>{{ $lesson->content ? 'Text' : ($lesson->file_path ? 'File' : '-') }}</td>
                                    <td>
                                        <div class="table-actions">
                                            <a class="btn ghost btn-small" href="{{ route('student.lessons.show', $lesson) }}">Open</a>
                                            @if ($lesson->file_path)
                                                <a class="btn ghost btn-small" href="{{ route('student.lessons.file', $lesson) }}">File</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="table-empty" colspan="6">No lessons found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @include('admin.users.partials.pagination', ['paginator' => $lessons])
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        const subjectSelect = document.getElementById('subject_id');
        const topicSelect = document.getElementById('topic_id');
        if (subjectSelect && topicSelect) {
            const loadTopics = async (selectedTopicId) => {
                const subjectId = subjectSelect.value;
                if (!subjectId) {
                    topicSelect.innerHTML = '<option value="">All topics</option>';
                    return;
                }

                topicSelect.innerHTML = '<option value="">Loading topics...</option>';
                try {
                    const url = new URL(topicSelect.dataset.topicsUrl, window.location.origin);
                    url.searchParams.set('subject_id', subjectId);
                    const response = await fetch(url.toString(), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        credentials: 'same-origin',
                    });
                    const data = response.ok ? await response.json() : [];
                    let options = '<option value="">All topics</option>';
                    data.forEach((topic) => {
                        const selected = selectedTopicId && String(topic.id) === String(selectedTopicId) ? 'selected' : '';
                        options += `<option value="${topic.id}" ${selected}>${topic.title}</option>`;
                    });
                    topicSelect.innerHTML = options;
                } catch (error) {
                    topicSelect.innerHTML = '<option value="">All topics</option>';
                }
            };

            subjectSelect.addEventListener('change', () => loadTopics(null));

            const initialSelected = topicSelect.dataset.selectedTopic || null;
            loadTopics(initialSelected);
        }
    </script>
@endpush
