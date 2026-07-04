@extends('layouts.app')

@section('title', 'Meet the Developers')

@section('content')
<style>
    @import url('https://fonts.bunny.net/css?family=cinzel:400,700,800|nunito-sans:300,400,500,600,700,800');

    * { box-sizing: border-box; margin: 0; padding: 0; }

    body { font-family: 'Nunito Sans', sans-serif; }

    .dev-page {
        min-height: 100vh;
        background-color: #0c1580;
        background-image:
            repeating-linear-gradient(
                45deg,
                rgba(255,255,255,0.07) 0,
                rgba(255,255,255,0.07) 1px,
                transparent 1px,
                transparent 48px
            ),
            repeating-linear-gradient(
                -45deg,
                rgba(255,255,255,0.07) 0,
                rgba(255,255,255,0.07) 1px,
                transparent 1px,
                transparent 48px
            );
        display: flex;
        flex-direction: column;
    }

    /* ── Topbar ── */
    .dev-topbar {
        background: rgba(9,16,122,0.85);
        border-bottom: 1px solid rgba(255,255,255,0.08);
        backdrop-filter: blur(6px);
        padding: 0.85rem 2.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 40;
    }

    .dev-topbar-brand {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .dev-topbar-seal {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: contain;
    }

    .dev-topbar-text h1 {
        font-family: 'Cinzel', serif;
        font-size: 0.88rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #fff;
        line-height: 1.1;
    }

    .dev-topbar-text p {
        font-size: 0.68rem;
        color: rgba(255,255,255,0.5);
        letter-spacing: 0.04em;
        text-transform: uppercase;
        margin-top: 0.1rem;
    }

    .dev-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.45rem 1.1rem;
        border: 1.5px solid rgba(255,255,255,0.5);
        border-radius: 8px;
        color: #fff;
        font-family: 'Nunito Sans', sans-serif;
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        transition: background 0.15s, border-color 0.15s;
        background: transparent;
    }

    .dev-back-btn:hover {
        background: rgba(255,255,255,0.1);
        border-color: #fff;
    }

    /* ── Hero ── */
    .dev-hero {
        text-align: center;
        padding: 4.5rem 2rem 3rem;
    }

    .dev-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        font-family: 'Nunito Sans', sans-serif;
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: #c9a227;
        margin-bottom: 1.1rem;
    }

    .dev-eyebrow-diamond {
        display: inline-block;
        width: 7px;
        height: 7px;
        background: #c9a227;
        transform: rotate(45deg);
    }

    .dev-hero h2 {
        font-family: 'Cinzel', serif;
        font-size: clamp(2.2rem, 5vw, 3.5rem);
        font-weight: 700;
        color: #fff;
        letter-spacing: 0.03em;
        margin-bottom: 1rem;
    }

    .dev-hero p {
        font-size: 0.95rem;
        color: rgba(255,255,255,0.55);
        max-width: 480px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* ── Cards ── */
    .dev-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 2rem 4rem;
        flex: 1;
    }

    @media (max-width: 768px) {
        .dev-grid { grid-template-columns: 1fr; }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .dev-grid { grid-template-columns: repeat(2, 1fr); }
    }

    .dev-card {
        background: #162282;
        border: 1px solid rgba(201,162,39,0.2);
        border-top: 2px solid rgba(201,162,39,0.45);
        border-radius: 16px;
        padding: 1.75rem 1.75rem 1.5rem;
        position: relative;
    }


    .dev-card-diamond {
        width: 10px;
        height: 10px;
        background: #c9a227;
        transform: rotate(45deg);
        margin-bottom: 1.1rem;
    }

    .dev-card-name {
        font-family: 'Cinzel', serif;
        font-size: 1.1rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: 0.02em;
        margin-bottom: 0.55rem;
    }

    .dev-card-wave {
        color: #c9a227;
        font-size: 1rem;
        letter-spacing: 0.1em;
        margin-bottom: 0.85rem;
        display: block;
    }

    .dev-card-role {
        font-family: 'Nunito Sans', sans-serif;
        font-size: 0.7rem;
        font-weight: 800;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.45);
    }

    /* ── Footer ── */
    .dev-footer {
        background: #09107a;
        padding: 0.85rem 2.5rem;
    }

    .dev-footer-inner {
        max-width: 1280px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .dev-footer-title {
        font-family: 'Cinzel', serif;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #fff;
    }

    .dev-footer-tagline {
        font-family: 'Cinzel', serif;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #fff;
    }
</style>

<div class="dev-page">

    {{-- Topbar --}}
    <div class="dev-topbar">
        <div class="dev-topbar-brand">
            <img src="{{ asset('images/ADDU-SEAL-Colored.png') }}" alt="ADDU Seal" class="dev-topbar-seal" onerror="this.style.display='none'">
            <div class="dev-topbar-text">
                <h1>Ateneo de Davao University</h1>
                <p>Alumni Affairs Office</p>
            </div>
        </div>
        <a href="/" class="dev-back-btn">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back to Home
        </a>
    </div>

    {{-- Hero --}}
    <div class="dev-hero">
        <div class="dev-eyebrow">
            <span class="dev-eyebrow-diamond"></span>
            Alumni Affairs Office
            <span class="dev-eyebrow-diamond"></span>
        </div>
        <h2>Meet the Developers</h2>
        <p>The team behind the AdDU Graduate Tracer Study platform.</p>
    </div>

    {{-- Cards --}}
    <div class="dev-grid">
        @php
        $developers = [
            ['name' => 'Developer Name', 'role' => 'Project Lead'],
            ['name' => 'Developer Name', 'role' => 'Frontend Developer'],
            ['name' => 'Developer Name', 'role' => 'Backend Developer'],
            ['name' => 'Developer Name', 'role' => 'UI/UX Designer'],
            ['name' => 'Developer Name', 'role' => 'Database Administrator'],
            ['name' => 'Developer Name', 'role' => 'Quality Assurance'],
        ];
        @endphp

        @foreach($developers as $dev)
        <div class="dev-card">
            <div class="dev-card-diamond"></div>
            <div class="dev-card-name">{{ $dev['name'] }}</div>
            <span class="dev-card-wave">~ ~ ~</span>
            <div class="dev-card-role">{{ $dev['role'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Footer --}}
    <div class="dev-footer">
        <div class="dev-footer-inner">
            <span class="dev-footer-title">Ateneo Graduate Tracer Study</span>
            <span class="dev-footer-tagline">Strong in Faith That Does Justice</span>
        </div>
    </div>

</div>
@endsection
