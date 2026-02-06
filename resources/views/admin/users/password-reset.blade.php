@extends('admin.layout')

@section('title', 'Password Reset')

@section('main')
    <main class="main">
        <header class="topbar">
            <div class="greeting">
                <p class="eyebrow">Admin User Management</p>
                <h1>Password Reset</h1>
                <p class="subtext">Share this password securely. It is shown only once.</p>
            </div>
            <div class="actions">
                <a class="btn ghost" href="{{ route($backRoute) }}">Back to List</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="btn primary" type="submit">Logout</button>
                </form>
            </div>
        </header>

        <section class="panel">
            <div class="panel-header">
                <h4>Account Summary</h4>
                <span class="badge blue">{{ ucfirst($user->role) }}</span>
            </div>
            <div class="panel-body">
                <div class="item">
                    <div class="item-info">
                        <p>{{ $user->name }}</p>
                        <span>{{ $user->email }}</span>
                    </div>
                </div>

                <div class="item">
                    <div class="item-info">
                        <p>New Password</p>
                        <span class="password-note">Shown once. Copy and share securely.</span>
                    </div>
                    <div class="password-box" data-copy-target>{{ $generatedPassword }}</div>
                    <button class="btn ghost btn-small" type="button" data-copy-button>Copy</button>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        const copyButton = document.querySelector('[data-copy-button]');
        const copyTarget = document.querySelector('[data-copy-target]');
        if (copyButton && copyTarget) {
            copyButton.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(copyTarget.textContent.trim());
                    copyButton.textContent = 'Copied';
                    setTimeout(() => {
                        copyButton.textContent = 'Copy';
                    }, 1500);
                } catch (error) {
                    copyButton.textContent = 'Copy failed';
                }
            });
        }
    </script>
@endpush
