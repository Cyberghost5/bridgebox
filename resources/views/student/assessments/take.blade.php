@extends('student.layout')

@section('title', 'Take ' . ucfirst($type))

@section('main')
    @php($routePrefix = $type === 'exam' ? 'student.exams' : 'student.quizzes')
    @php($timeLimit = (int) ($assessment->time_limit_minutes ?? 0))
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">{{ ucfirst($type) }}</p>
                <h1>{{ $assessment->title }}</h1>
                <p class="subtext">Answer all questions below.</p>
            </div>
            <div class="actions">
                <a class="btn ghost" href="{{ route($routePrefix . '.index') }}">Back to {{ ucfirst($type) }}s</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn primary" type="submit">Logout</button>
                </form>
            </div>
        </header>

        <div class="alert alert-error" role="status">
            <span data-alert-message>Leaving this {{ $type }} attempt will score you zero. Do not refresh or navigate away.</span>
        </div>

        <section class="panel">
            <div class="panel-header">
                <h4>Assessment Details</h4>
                <span class="badge gold">{{ $questions->count() }} Questions</span>
            </div>
            <div class="panel-body">
                <div class="item-list" style="display:flex;flex-direction:column;gap:6px;">
                    <div class="item">
                        <div class="item-info">
                            <p>Subject</p>
                            <span>{{ $assessment->subject?->name ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-info">
                            <p>Topic</p>
                            <span>{{ $assessment->topic?->title ?? '-' }}</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-info">
                            <p>Duration</p>
                            <span>{{ $timeLimit ? $timeLimit . ' min' : 'No limit' }}</span>
                        </div>
                    </div>
                    <div class="item">
                        <div class="item-info">
                            <p>Time Remaining</p>
                            <span id="time-remaining"
                                data-time-limit="{{ $timeLimit }}"
                                data-started-at="{{ $attempt->started_at?->timestamp ?? '' }}">
                                {{ $timeLimit ? '--:--' : 'No limit' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="panel">
            <div class="panel-header">
                <h4>Questions</h4>
                <span class="badge blue">Attempt</span>
            </div>
            <div class="panel-body">
                <form class="form-grid" action="{{ route($routePrefix . '.submit', $attempt) }}" method="post" id="assessment-form">
                    @csrf
                    <div class="form-field form-field-full">
                        <p class="text-muted">Choose one answer per question.</p>
                    </div>

                    @foreach ($questions as $index => $question)
                        <div class="form-field form-field-full">
                            <label>Question {{ $index + 1 }}</label>
                            <div style="font-weight:600;color:var(--ink);">{{ $question->prompt }}</div>
                            <div style="display:flex;flex-direction:column;gap:8px;margin-top:10px;">
                                @foreach ($question->options->sortBy('order') as $option)
                                    <label class="checkbox">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}">
                                        <span>{{ $option->option_text }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div class="form-actions">
                        <button class="btn primary" type="submit">Submit {{ ucfirst($type) }}</button>
                    </div>
                </form>
            </div>
        </section>

        <div class="modal" id="leave-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="leave-title">
            <div class="modal-card">
                <div class="modal-header">
                    <h3 id="leave-title">Leave Attempt?</h3>
                    <button class="icon-close" type="button" data-leave-cancel aria-label="Close dialog">&times;</button>
                </div>
                <p class="modal-message">Leaving now will submit this {{ $type }} with a score of zero. Do you want to leave?</p>
                <div class="modal-actions">
                    <button class="btn ghost" type="button" data-leave-cancel>Stay</button>
                    <button class="btn primary" type="button" data-leave-confirm>Leave and score zero</button>
                </div>
            </div>
        </div>

        <div id="attempt-guard"
            data-back-url="{{ route($routePrefix . '.index') }}"
            data-result-url="{{ route($routePrefix . '.result', $attempt) }}"
            data-forfeit-url="{{ route($routePrefix . '.forfeit', $attempt) }}"
            data-csrf="{{ csrf_token() }}">
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        const guard = document.getElementById('attempt-guard');
        const modal = document.getElementById('leave-modal');
        const leaveButtons = document.querySelectorAll('[data-leave-confirm]');
        const cancelButtons = document.querySelectorAll('[data-leave-cancel]');
        const assessmentForm = document.getElementById('assessment-form');
        const timerEl = document.getElementById('time-remaining');
        const backUrl = guard ? guard.dataset.backUrl : null;
        const resultUrl = guard ? guard.dataset.resultUrl : null;
        const forfeitUrl = guard ? guard.dataset.forfeitUrl : null;
        const csrfToken = guard ? guard.dataset.csrf : null;
        let pendingUrl = null;
        let pendingForm = null;
        let allowNavigation = false;
        let forfeiting = false;

        const openModal = () => {
            if (!modal) {
                return;
            }
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
        };

        const closeModal = () => {
            if (!modal) {
                return;
            }
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
        };

        const sendForfeit = async () => {
            if (forfeiting || !forfeitUrl || !csrfToken) {
                return;
            }
            forfeiting = true;
            try {
                await fetch(forfeitUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: new URLSearchParams({ _token: csrfToken }),
                    credentials: 'same-origin',
                    keepalive: true,
                });
            } catch (error) {
                // ignore
            }
        };

        const confirmLeave = async () => {
            await sendForfeit();
            allowNavigation = true;
            closeModal();
            if (pendingForm) {
                pendingForm.submit();
                return;
            }
            if (pendingUrl) {
                window.location.href = pendingUrl;
                return;
            }
            if (backUrl) {
                window.location.href = backUrl;
            }
        };

        cancelButtons.forEach((button) => {
            button.addEventListener('click', () => {
                pendingUrl = null;
                pendingForm = null;
                closeModal();
            });
        });

        leaveButtons.forEach((button) => {
            button.addEventListener('click', () => {
                confirmLeave();
            });
        });

        if (assessmentForm) {
            assessmentForm.addEventListener('submit', () => {
                allowNavigation = true;
            });
        }

        const guardNavigation = (event, url, form) => {
            if (allowNavigation || forfeiting) {
                return;
            }
            if (event) {
                event.preventDefault();
            }
            pendingUrl = url || null;
            pendingForm = form || null;
            openModal();
        };

        document.querySelectorAll('a[href]').forEach((link) => {
            const href = link.getAttribute('href');
            if (!href || href.startsWith('#') || href.startsWith('javascript:')) {
                return;
            }
            link.addEventListener('click', (event) => guardNavigation(event, href, null));
        });

        document.querySelectorAll('form').forEach((form) => {
            if (form === assessmentForm) {
                return;
            }
            form.addEventListener('submit', (event) => guardNavigation(event, null, form));
        });

        if (window.history && window.history.pushState) {
            window.history.pushState({ guard: true }, '', window.location.href);
            window.addEventListener('popstate', () => {
                if (allowNavigation) {
                    return;
                }
                window.history.pushState({ guard: true }, '', window.location.href);
                guardNavigation(null, backUrl, null);
            });
        }

        window.addEventListener('beforeunload', (event) => {
            if (allowNavigation || forfeiting) {
                return;
            }
            event.preventDefault();
            event.returnValue = '';
        });

        window.addEventListener('pagehide', () => {
            if (allowNavigation || forfeiting) {
                return;
            }
            if (!forfeitUrl || !csrfToken) {
                return;
            }
            const data = new FormData();
            data.append('_token', csrfToken);
            if (navigator.sendBeacon) {
                navigator.sendBeacon(forfeitUrl, data);
            } else {
                fetch(forfeitUrl, {
                    method: 'POST',
                    body: data,
                    credentials: 'same-origin',
                    keepalive: true,
                });
            }
        });

        if (timerEl && timerEl.dataset.timeLimit && timerEl.dataset.startedAt) {
            const timeLimit = Number.parseInt(timerEl.dataset.timeLimit, 10);
            const startedAt = Number.parseInt(timerEl.dataset.startedAt, 10) * 1000;

            if (timeLimit > 0 && startedAt > 0) {
                const endAt = startedAt + timeLimit * 60 * 1000;

                const formatTime = (ms) => {
                    const totalSeconds = Math.max(0, Math.floor(ms / 1000));
                    const hours = Math.floor(totalSeconds / 3600);
                    const minutes = Math.floor((totalSeconds % 3600) / 60);
                    const seconds = totalSeconds % 60;
                    if (hours > 0) {
                        return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    }
                    return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                };

                const tick = async () => {
                    const remaining = endAt - Date.now();
                    timerEl.textContent = formatTime(remaining);
                    if (remaining <= 0 && !forfeiting) {
                        pendingUrl = resultUrl;
                        await confirmLeave();
                    }
                };

                tick();
                window.setInterval(tick, 1000);
            }
        }
    </script>
@endpush
