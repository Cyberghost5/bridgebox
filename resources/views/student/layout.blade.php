<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BridgeBox Student')</title>
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-alerts.css') }}">
</head>
<body>
    @php($navSection = $navSection ?? null)
    <div class="page">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-mark">
                    <img class="brand-logo" src="{{ asset('assets/images/favicon.png') }}" alt="BridgeBox logo">
                </div>
                <span class="brand-name">BridgeBox</span>
            </div>
            <nav class="nav">
                <a class="nav-item {{ request()->routeIs('dashboard.student') ? 'active' : '' }}" href="{{ route('dashboard.student') }}" aria-label="Student dashboard">
                    <i class="fa-solid fa-house" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ request()->routeIs('student.subjects.*') ? 'active' : '' }}" href="{{ route('student.subjects.index') }}" aria-label="Subjects">
                    <i class="fa-solid fa-book" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ request()->routeIs('student.topics.*') ? 'active' : '' }}" href="{{ route('student.topics.index') }}" aria-label="Topics">
                    <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ request()->routeIs('student.lessons.*') ? 'active' : '' }}" href="{{ route('student.lessons.index') }}" aria-label="Lessons">
                    <i class="fa-solid fa-book-open" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ request()->routeIs('student.assignments.*') ? 'active' : '' }}" href="{{ route('student.assignments.index') }}" aria-label="Assignments">
                    <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ request()->routeIs('student.progress.*') ? 'active' : '' }}" href="{{ route('student.progress.index') }}" aria-label="Progress">
                    <i class="fa-solid fa-chart-line" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ request()->routeIs('student.quizzes.*') ? 'active' : '' }}" href="{{ route('student.quizzes.index') }}" aria-label="Quizzes">
                    <i class="fa-solid fa-circle-question" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ request()->routeIs('student.exams.*') ? 'active' : '' }}" href="{{ route('student.exams.index') }}" aria-label="Exams">
                    <i class="fa-solid fa-clipboard-check" aria-hidden="true"></i>
                </a>
            </nav>
            <div class="sidebar-footer">
                <div class="status-dot"></div>
                <span>Student</span>
            </div>
            @if (session('impersonator_id'))
                <form class="sidebar-logout" action="{{ route('impersonate.stop') }}" method="post">
                    @csrf
                    <button class="btn ghost btn-small" type="submit">Return to Admin</button>
                </form>
            @endif
            <form class="sidebar-logout" action="{{ route('logout') }}" method="post">
                @csrf
                <button class="btn ghost btn-small" type="submit">Logout</button>
            </form>
        </aside>

        @yield('main')
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    @stack('scripts')
</body>
</html>
