<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BridgeBox Admin')</title>
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
                <a class="nav-item {{ request()->routeIs('dashboard.admin*') ? 'active' : '' }}" href="{{ route('dashboard.admin') }}" aria-label="Admin control room">
                    <i class="fa-solid fa-house" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ (request()->routeIs('admin.users.teachers.*') || $navSection === 'teachers') ? 'active' : '' }}" href="{{ route('admin.users.teachers.index') }}" aria-label="Manage teachers">
                    <i class="fa-solid fa-chalkboard-user" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ (request()->routeIs('admin.users.students.*') || $navSection === 'students') ? 'active' : '' }}" href="{{ route('admin.users.students.index') }}" aria-label="Manage students">
                    <i class="fa-solid fa-user-graduate" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ (request()->routeIs('admin.classes.*') || $navSection === 'classes') ? 'active' : '' }}" href="{{ route('admin.classes.index') }}" aria-label="Manage classes">
                    <i class="fa-solid fa-people-roof" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ (request()->routeIs('admin.subjects.*') || $navSection === 'subjects') ? 'active' : '' }}" href="{{ route('admin.subjects.index') }}" aria-label="Manage subjects">
                    <i class="fa-solid fa-book" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ (request()->routeIs('admin.departments.*') || $navSection === 'departments') ? 'active' : '' }}" href="{{ route('admin.departments.index') }}" aria-label="Manage departments">
                    <i class="fa-solid fa-building-columns" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ (request()->routeIs('admin.topics.*') || $navSection === 'topics') ? 'active' : '' }}" href="{{ route('admin.topics.index') }}" aria-label="Manage topics">
                    <i class="fa-solid fa-list-check" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ (request()->routeIs('admin.assignments.*') || $navSection === 'assignments') ? 'active' : '' }}" href="{{ route('admin.assignments.index') }}" aria-label="Manage assignments">
                    <i class="fa-solid fa-file-lines" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ (request()->routeIs('admin.quizzes.*') || $navSection === 'quizzes') ? 'active' : '' }}" href="{{ route('admin.quizzes.index') }}" aria-label="Manage quizzes">
                    <i class="fa-solid fa-circle-question" aria-hidden="true"></i>
                </a>
                <a class="nav-item {{ (request()->routeIs('admin.exams.*') || $navSection === 'exams') ? 'active' : '' }}" href="{{ route('admin.exams.index') }}" aria-label="Manage exams">
                    <i class="fa-solid fa-clipboard-check" aria-hidden="true"></i>
                </a>
                <!-- <button class="nav-item" aria-label="System status">
                    <i class="fa-solid fa-chart-line" aria-hidden="true"></i>
                </button> -->
                <a class="nav-item {{ (request()->routeIs('admin.logs.*') || $navSection === 'logs') ? 'active' : '' }}" href="{{ route('admin.logs.index') }}" aria-label="Admin logs">
                    <i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i>
                </a>
            </nav>
            <div class="sidebar-footer">
                <div class="status-dot"></div>
                <span>Admin</span>
            </div>
        </aside>

        @yield('main')
    </div>

    <div class="modal" id="confirm-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="confirm-title">
        <div class="modal-card">
            <div class="modal-header">
                <h3 id="confirm-title">Confirm Action</h3>
                <button class="icon-close" type="button" data-confirm-close aria-label="Close dialog">&times;</button>
            </div>
            <p class="modal-message" data-confirm-message>Are you sure?</p>
            <div class="modal-actions">
                <button class="btn ghost" type="button" data-confirm-no>Cancel</button>
                <button class="btn primary" type="button" data-confirm-yes>Confirm</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/admin-actions.js') }}"></script>
    <script src="{{ asset('assets/js/admin-dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    @stack('scripts')
</body>
</html>
