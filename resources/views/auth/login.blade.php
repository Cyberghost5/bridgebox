<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $role }} Login | BridgeBox</title>
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
</head>
<body class="auth-body">
    <div class="auth-shell">
        <section class="login-screen">
            <div class="login-panel">
                <a class="back-link" href="{{ route('landing') }}">← Back to roles</a>

                <div class="login-header">
                    <span class="role-pill">{{ $role }}</span>
                    <h1>{{ $role }} Login</h1>
                    <p class="subtext">{{ $subtitle }}</p>
                </div>

                @if (session('error'))
                    <div class="alert">{{ session('error') }}</div>
                @elseif ($errors->any())
                    <div class="alert">{{ $errors->first() }}</div>
                @endif

                <form class="login-form" action="{{ route('login.submit', ['role' => $roleKey]) }}" method="post">
                    @csrf
                    <div class="field">
                        <label for="email">Email or username</label>
                        <input id="email" name="identifier" type="text" placeholder="name@school.edu" autocomplete="username" value="{{ old('identifier') }}">
                    </div>

                    <div class="field">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" placeholder="Enter your password" autocomplete="current-password">
                    </div>

                    <button class="btn primary" type="submit">Login</button>
                    <button class="forgot-link" type="button" data-modal-open="forgot-modal">Forgot password?</button>
                </form>
            </div>
        </section>
    </div>

    <div class="modal" id="forgot-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="forgot-title">
        <div class="modal-card">
            <div class="modal-header">
                <h2 id="forgot-title">Offline Password Help</h2>
                <button class="icon-close" type="button" data-modal-close="forgot-modal" aria-label="Close dialog">×</button>
            </div>
            <p>BridgeBox is designed to work offline, so password resets happen locally.</p>
            <ul class="modal-list">
                <li>Ask your school admin for a local reset code.</li>
                <li>If you are an admin, use the device settings panel to issue a reset.</li>
                <li>If neither is available, wait until connectivity returns to sync a reset.</li>
            </ul>
            <button class="btn primary" type="button" data-modal-close="forgot-modal">Got it</button>
        </div>
    </div>

    <script src="{{ asset('assets/js/auth.js') }}"></script>
    <script src="{{ asset('assets/js/offline.js') }}"></script>
</body>
</html>
