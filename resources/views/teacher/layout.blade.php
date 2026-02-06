<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BridgeBox Teacher')</title>
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
                <a class="nav-item {{ request()->routeIs('dashboard.teacher') ? 'active' : '' }}" href="{{ route('dashboard.teacher') }}" aria-label="Teacher dashboard">
                    <i class="fa-solid fa-house" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ (request()->routeIs('teacher.students.*') || $navSection === 'students') ? 'active' : '' }}" href="{{ route('teacher.students.index') }}" aria-label="Students">
                    <i class="fa-solid fa-user-graduate" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ (request()->routeIs('teacher.classes.*') || $navSection === 'classes') ? 'active' : '' }}" href="{{ route('teacher.classes.index') }}" aria-label="Classes">
                    <i class="fa-solid fa-people-roof" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ (request()->routeIs('teacher.subjects.*') || $navSection === 'subjects') ? 'active' : '' }}" href="{{ route('teacher.subjects.index') }}" aria-label="Subjects">
                    <i class="fa-solid fa-book" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ (request()->routeIs('teacher.topics.*') || $navSection === 'topics') ? 'active' : '' }}" href="{{ route('teacher.topics.index') }}" aria-label="Topics">
                    <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ (request()->routeIs('teacher.assignments.*') || $navSection === 'assignments') ? 'active' : '' }}" href="{{ route('teacher.assignments.index') }}" aria-label="Assignments">
                    <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ (request()->routeIs('teacher.quizzes.*') || $navSection === 'quizzes') ? 'active' : '' }}" href="{{ route('teacher.quizzes.index') }}" aria-label="Quizzes">
                    <i class="fa-solid fa-circle-question" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ (request()->routeIs('teacher.exams.*') || $navSection === 'exams') ? 'active' : '' }}" href="{{ route('teacher.exams.index') }}" aria-label="Exams">
                    <i class="fa-solid fa-clipboard-check" aria-hidden="true"></i>
                </a>
            </nav>
            <div class="sidebar-footer">
                <div class="status-dot"></div>
                <span>Teacher</span>
            </div>
        </aside>

        @yield('main')
    </div>

    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    @stack('scripts')
</body>
</html>
