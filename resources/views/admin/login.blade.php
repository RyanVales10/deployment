@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<style>
    @import url('https://fonts.bunny.net/css?family=cinzel:700,800|nunito-sans:300,400,500,600,700,800');

    :root {
        --blue-dd: #09107a;
        --blue:    #1a24d2;
    }

    body { margin: 0; font-family: 'Nunito Sans', -apple-system, sans-serif; }

    .login-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        background-color: var(--blue);
        background-image:
            url('/images/pattern.png'),
            linear-gradient(160deg, #1a24d2 0%, #09107a 100%);
        background-repeat: repeat, no-repeat;
        background-size: 420px auto, cover;
        background-blend-mode: overlay, normal;
    }

    .login-card {
        background: #fff;
        border-radius: 14px;
        width: min(100%, 440px);
        padding: 2rem 2.25rem 2.25rem;
        box-shadow: 0 24px 60px rgba(0,0,0,0.28);
    }

    .login-seal {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .login-seal img {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        object-fit: contain;
    }

    .login-seal-placeholder {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: var(--blue);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-seal-placeholder svg {
        width: 32px;
        height: 32px;
        color: #fff;
    }

    .login-school-name {
        margin-top: 0.6rem;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--blue-dd);
        text-align: center;
    }

    .login-title {
        font-family: 'Cinzel', serif;
        font-size: 1.2rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: var(--blue-dd);
        margin: 0 0 0.3rem;
    }

    .login-sub {
        font-size: 0.84rem;
        color: #6b7a99;
        margin: 0 0 1.25rem;
    }

    .login-divider {
        border: none;
        border-top: 1px solid #e8edf6;
        margin-bottom: 1.25rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-label {
        display: block;
        font-size: 0.8rem;
        font-weight: 700;
        color: #3d4f6b;
        margin-bottom: 0.35rem;
    }

    .form-input {
        display: block;
        width: 100%;
        padding: 0.65rem 0.9rem;
        border: 1.5px solid #d0d9ec;
        border-radius: 8px;
        font-size: 0.88rem;
        color: #0d1b3e;
        background: #fff;
        transition: border-color 0.15s, box-shadow 0.15s;
        box-sizing: border-box;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(26,36,210,0.12);
    }

    .error-box {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        padding: 0.65rem 0.9rem;
        margin-bottom: 1rem;
        font-size: 0.82rem;
        color: #991b1b;
    }

    .error-box ul { margin: 0; padding: 0 0 0 1rem; }
    .error-box li { margin: 0; }

    .form-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 1.25rem;
    }

    .back-link {
        font-size: 0.82rem;
        color: #6b7a99;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .back-link:hover { color: var(--blue-dd); }

    .back-link::before { content: '←'; }

    .login-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.65rem 1.5rem;
        background: var(--blue-dd);
        color: #fff;
        font-family: 'Nunito Sans', sans-serif;
        font-size: 0.88rem;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.15s;
    }

    .login-btn:hover { background: var(--blue); }
</style>

<div class="login-page">
    <div class="login-card">

        <div class="login-seal">
            <img
                src="{{ asset('images/ADDU-SEAL-Colored.png') }}"
                alt="Ateneo de Davao University"
                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
            >
            <div class="login-seal-placeholder" style="display:none;">
                <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            </div>
            <span class="login-school-name">Ateneo de Davao University</span>
        </div>

        <h2 class="login-title">Admin Login</h2>
        <p class="login-sub">Use the registered admin account for sign in.</p>
        <hr class="login-divider">

        @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="form-group">
                <label for="admin_email" class="form-label">Email</label>
                <input
                    id="admin_email"
                    name="email"
                    type="email"
                    class="form-input"
                    value="{{ old('email', 'admin@addu.edu.ph') }}"
                    placeholder="admin@addu.edu.ph"
                    required
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="admin_password" class="form-label">Password</label>
                <input
                    id="admin_password"
                    name="password"
                    type="password"
                    class="form-input"
                    placeholder="••••••••"
                    required
                >
            </div>

            <div class="form-footer">
                <a href="{{ url('/') }}" class="back-link">Back to home</a>
                <button type="submit" class="login-btn">
                    Log In
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
