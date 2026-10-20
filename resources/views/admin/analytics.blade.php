@extends('layouts.app')

@section('title', 'Analytics - Admin')

@section('content')
<style>
    @import url('https://fonts.bunny.net/css?family=cinzel:400,700,800|nunito-sans:300,400,500,600,700,800');

    .admin-shell {
        --admin-blue: #09107a;
        --admin-gold: #f5b800;
        --admin-ink: #10233f;
        --admin-muted: #5a6b86;
        min-height: 100vh;
        background: #f0f2f8;
        font-family: 'Nunito Sans', -apple-system, sans-serif;
    }

    .admin-topbar {
        background: #09107a;
        border-bottom: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.2);
    }
    .admin-topbar-seal {
        width: 35px !important;
        height: 35px !important;
        min-width: 35px;
        max-width: 35px !important;
        max-height: 35px !important;
        border-radius: 50%;
        object-fit: contain;
        opacity: 0.9;
    }

    .admin-heading {
        font-family: 'Cinzel', serif;
        color: #fff;
        font-weight: 700;
        font-size: 0.82rem !important;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .admin-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        border-radius: 10px;
        font-weight: 700;
        font-family: 'Nunito Sans', sans-serif;
        font-size: 0.82rem;
        letter-spacing: 0.03em;
        transition: background 0.2s;
        background: transparent;
        color: #fff;
        border: 2.5px solid rgba(255,255,255,0.8);
        padding: 0.55rem 1rem;
        margin-right: 2.25rem;
        text-decoration: none;
        white-space: nowrap;
    }

    .admin-back-btn:hover { background: rgba(255,255,255,0.14); }

    .admin-tab-shell {
        background: #fff;
        border-bottom: 1px solid #e8edf6;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }

    .admin-tab-btn {
        padding: 0.75rem 1.1rem;
        border-bottom: 2.5px solid transparent;
        font-size: 0.88rem;
        font-family: 'Nunito Sans', sans-serif;
        font-weight: 700;
        background: none;
        border-top: none;
        border-left: none;
        border-right: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        transition: color 0.15s, border-color 0.15s;
    }

    .admin-tab-btn.active {
        color: #09107a;
        border-bottom-color: #09107a;
    }

    .admin-tab-btn.inactive { color: #6b7a99; }

    .admin-tab-btn.inactive:hover {
        color: #09107a;
        border-bottom-color: rgba(9,16,122,0.3);
    }

    .admin-panel,
    .admin-card,
    .admin-empty-state {
        background: rgba(255,255,255,0.96);
        border: 1px solid rgba(16,35,63,0.10);
        border-radius: 18px;
        box-shadow: 0 14px 30px rgba(16,35,63,0.07);
    }

    .admin-hero {
        background: linear-gradient(135deg, #09107a 0%, #1a24d2 100%);
        color: white;
        border-radius: 14px 14px 0 0;
        padding: 1.5rem 1.75rem;
    }

    .admin-hero-eyebrow {
        font-family: 'Cinzel', serif;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--admin-gold);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.4rem;
    }

    .admin-hero-eyebrow::before { content: '—'; }

    .admin-hero h1 {
        font-family: 'Cinzel', serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: 0.02em;
        margin-bottom: 0.3rem;
    }

    .admin-hero .muted {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.65);
    }

    .admin-hero-badges {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .admin-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.2);
        border-radius: 999px;
        padding: 0.35rem 1rem;
        font-size: 0.85rem;
        font-weight: 700;
        color: rgba(255,255,255,0.85);
    }

    .admin-hero-badge span { color: var(--admin-gold); font-weight: 800; }

    .analytics-section-title {
        font-family: 'Cinzel', serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--admin-ink);
        letter-spacing: 0.01em;
    }

    .analytics-section-desc {
        font-size: 0.82rem;
        color: var(--admin-muted);
        margin-top: 0.15rem;
    }

    .analytics-legend-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.75rem;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(16,35,63,0.06);
        font-size: 0.85rem;
    }

    .analytics-legend-item:last-child { border-bottom: none; }

    .analytics-legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 3px;
        display: inline-block;
        margin-right: 0.55rem;
        flex-shrink: 0;
    }

    .analytics-legend-label {
        display: flex;
        align-items: center;
        color: var(--admin-ink);
        font-weight: 600;
    }

    .analytics-legend-value {
        color: var(--admin-muted);
        font-weight: 700;
        white-space: nowrap;
    }

    .analytics-select {
        font-family: 'Nunito Sans', sans-serif;
        font-size: 0.82rem;
        font-weight: 700;
        color: var(--admin-blue);
        background: #f4f6fb;
        border: 1px solid rgba(16,35,63,0.12);
        border-radius: 8px;
        padding: 0.45rem 0.75rem;
        cursor: pointer;
    }

    .admin-topbar-row {
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 2.5rem;
    }

    .admin-topbar-brand {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-left: 1.5rem;
        min-width: 0;
    }

    /* ── Responsive ── */
    @media (max-width: 640px) {
        .admin-topbar-row {
            height: auto;
            flex-wrap: wrap;
            padding: 0.6rem 1.1rem;
            row-gap: 0.5rem;
        }
        .admin-topbar-brand { margin-left: 0; }
        .admin-heading { font-size: 0.72rem !important; }
        .admin-topbar-sub { font-size: 0.6rem !important; }
        .admin-back-btn { margin-right: 0 !important; padding: 0.4rem 0.8rem !important; font-size: 0.76rem !important; }
        .admin-tab-btn { padding: 0.55rem 0.8rem !important; font-size: 0.8rem !important; }
    }
</style>

<div class="admin-shell" x-data="analyticsApp()" x-cloak>
    {{-- Admin Header --}}
    <div class="admin-topbar sticky top-0 z-40">
        <div class="admin-topbar-row">
            <div class="admin-topbar-brand">
                <img src="{{ asset('images/ADDU-SEAL-Colored.png') }}" alt="" class="admin-topbar-seal" onerror="this.style.display='none'">
                <div>
                    <h1 class="admin-heading" style="line-height:1.3;margin:0;">Tracer Study Admin</h1>
                    <p class="admin-topbar-sub" style="font-family:'Cinzel',serif;font-size:0.72rem;font-weight:700;color:rgba(255,255,255,0.55);letter-spacing:0.06em;margin:0;line-height:1.3;">Graduate Tracer Study</p>
                </div>
            </div>
            <a href="/" class="admin-back-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Home
            </a>
        </div>

        {{-- Navigation Tabs --}}
        <div class="admin-tab-shell">
            <nav class="max-w-7xl mx-auto px-6 flex gap-1 -mb-px overflow-x-auto">
                <a href="{{ route('admin.dashboard') }}" class="admin-tab-btn inactive whitespace-nowrap">Dashboard</a>
                <a href="/admin/responses" class="admin-tab-btn inactive whitespace-nowrap">Responses</a>
                <a href="/admin/analytics" class="admin-tab-btn active whitespace-nowrap">Analytics</a>
            </nav>
        </div>
    </div>{{-- /admin-topbar --}}

    <div class="max-w-7xl mx-auto px-6 py-8">
        {{-- Header --}}
        <div class="admin-hero mb-6" style="border-radius:14px;box-shadow:0 14px 30px rgba(16,35,63,0.12);">
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <div>
                    <p class="admin-hero-eyebrow">Survey Analytics</p>
                    <h1>Tracer Study Analytics</h1>
                    <p class="muted">Employment and income insights drawn from submitted survey responses</p>
                </div>
                <div class="admin-hero-badges">
                    <div class="admin-hero-badge">Respondents <span x-text="totalRespondents"></span></div>
                </div>
            </div>
        </div>

        <div>
                <template x-if="totalRespondents === 0">
                    <div class="admin-empty-state text-center py-20">
                        <svg class="w-16 h-16 mx-auto mb-4 text-[#003087] opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <h2 class="text-xl font-extrabold text-[#10233f] mb-1">No data yet</h2>
                        <p class="text-sm" style="color:var(--admin-muted);">Charts will populate once survey responses are submitted.</p>
                    </div>
                </template>

                <template x-if="totalRespondents > 0">
                    <div class="flex flex-col gap-6">

                        {{-- Employment Status Overview --}}
                        <div class="admin-card p-6">
                            <h2 class="analytics-section-title">Employment Status Overview</h2>
                            <p class="analytics-section-desc">Breakdown of alumni respondents by current employment status</p>
                            <div class="mt-5 grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6 items-center">
                                <div style="position:relative;height:260px;">
                                    <canvas id="employmentChart"></canvas>
                                </div>
                                <div>
                                    <template x-for="item in employmentLegend" :key="item.label">
                                        <div class="analytics-legend-item">
                                            <span class="analytics-legend-label">
                                                <span class="analytics-legend-dot" :style="'background:' + item.color"></span>
                                                <span x-text="item.label"></span>
                                            </span>
                                            <span class="analytics-legend-value">
                                                <span x-text="item.count"></span> · <span x-text="item.pct"></span>%
                                            </span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        {{-- Job-Degree Alignment --}}
                        <div class="admin-card p-6">
                            <h2 class="analytics-section-title">Job and Degree Alignment by Program</h2>
                            <p class="analytics-section-desc">How closely employed alumni's current job matches their degree across programs</p>
                            <div class="mt-5" :style="'position:relative;height:' + alignmentChartHeight + 'px;'">
                                <canvas id="alignmentChart"></canvas>
                            </div>
                        </div>

                        {{-- Monthly Income Distribution --}}
                        <div class="admin-card p-6">
                            <div class="flex items-center justify-between gap-4 flex-wrap">
                                <div>
                                    <h2 class="analytics-section-title">Monthly Income Distribution</h2>
                                    <p class="analytics-section-desc">First job vs. Current job monthly income comparison</p>
                                </div>
                                <select class="analytics-select" x-model="selectedProgram" @change="updateIncomeChart()">
                                    <template x-for="program in programOptions" :key="program">
                                        <option :value="program" x-text="program"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="mt-5" style="position:relative;height:320px;">
                                <canvas id="incomeChart"></canvas>
                            </div>
                        </div>

                    </div>
                </template>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
function analyticsApp() {
    return {
        employmentStatus: @json($employmentStatus),
        alignmentByProgram: @json($alignmentByProgram),
        incomeByProgram: @json($incomeByProgram),
        incomeBrackets: @json($incomeBrackets),
        selectedProgram: 'All Programs',
        incomeChart: null,

        colors: {
            'Employed': '#09107a',
            'Self-employed/Entrepreneur': '#f5b800',
            'Pursuing Further Studies': '#1a24d2',
            'Unemployed': '#c53030',
            'Not Seeking Employment': '#5a6b86',
        },

        get totalRespondents() {
            return Object.values(this.employmentStatus).reduce((a, b) => a + b, 0);
        },

        get employmentLegend() {
            const total = this.totalRespondents;
            return Object.entries(this.employmentStatus).map(([label, count]) => ({
                label,
                count,
                pct: total > 0 ? Math.round((count / total) * 1000) / 10 : 0,
                color: this.colors[label] || '#5a6b86',
            }));
        },

        get programOptions() {
            return Object.keys(this.incomeByProgram);
        },

        get alignmentChartHeight() {
            const programCount = Object.keys(this.alignmentByProgram).length;
            return Math.max(180, programCount * 56);
        },

        incomeChartData() {
            const data = this.incomeByProgram[this.selectedProgram] || { first: [], current: [] };
            return {
                labels: this.incomeBrackets,
                datasets: [
                    { label: 'First Job', data: data.first, backgroundColor: '#f5b800', borderRadius: 6, maxBarThickness: 42 },
                    { label: 'Current Job', data: data.current, backgroundColor: '#09107a', borderRadius: 6, maxBarThickness: 42 },
                ],
            };
        },

        updateIncomeChart() {
            if (!this.incomeChart) return;
            this.incomeChart.data = this.incomeChartData();
            this.incomeChart.update();
        },

        init() {
            if (this.totalRespondents === 0) return;

            this.$nextTick(() => {
                new Chart(document.getElementById('employmentChart'), {
                    type: 'doughnut',
                    data: {
                        labels: this.employmentLegend.map(i => i.label),
                        datasets: [{
                            data: this.employmentLegend.map(i => i.count),
                            backgroundColor: this.employmentLegend.map(i => i.color),
                            borderWidth: 2,
                            borderColor: '#fff',
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '62%',
                        plugins: { legend: { display: false } },
                    },
                });

                const programs = Object.keys(this.alignmentByProgram);
                new Chart(document.getElementById('alignmentChart'), {
                    type: 'bar',
                    data: {
                        labels: programs,
                        datasets: [
                            { label: 'Aligned', data: programs.map(p => this.alignmentByProgram[p]['Aligned']), backgroundColor: '#09107a' },
                            { label: 'Partially Aligned', data: programs.map(p => this.alignmentByProgram[p]['Partially Aligned']), backgroundColor: '#f5b800' },
                            { label: 'Not Aligned', data: programs.map(p => this.alignmentByProgram[p]['Not Aligned']), backgroundColor: '#c53030' },
                        ],
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: { stacked: true, min: 0, max: 100, ticks: { callback: v => v + '%' } },
                            y: { stacked: true },
                        },
                        plugins: {
                            legend: { position: 'bottom', labels: { font: { family: 'Nunito Sans' }, boxWidth: 12 } },
                            tooltip: { callbacks: { label: ctx => `${ctx.dataset.label}: ${ctx.parsed.x}%` } },
                        },
                    },
                });

                this.incomeChart = new Chart(document.getElementById('incomeChart'), {
                    type: 'bar',
                    data: this.incomeChartData(),
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } },
                        plugins: {
                            legend: { position: 'bottom', labels: { font: { family: 'Nunito Sans' }, boxWidth: 12 } },
                        },
                    },
                });
            });
        },
    };
}
</script>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection
