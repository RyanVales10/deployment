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

    /* ── Program filter toolbar ── */
    .analytics-toolbar {
        display: flex;
        align-items: center;
        gap: 0.9rem;
        flex-wrap: wrap;
        padding: 0.85rem 1rem;
        position: relative;
        z-index: 10;
    }

    .analytics-filter { position: relative; }

    .analytics-filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
        font-family: 'Nunito Sans', sans-serif;
        font-size: 0.84rem;
        font-weight: 700;
        color: #fff;
        background: var(--admin-blue);
        border: none;
        border-radius: 999px;
        padding: 0.5rem 0.95rem;
        cursor: pointer;
        transition: background 0.15s;
    }

    .analytics-filter-btn:hover { background: #1a24d2; }

    .analytics-filter-count {
        background: rgba(255,255,255,0.18);
        color: var(--admin-gold);
        border-radius: 999px;
        padding: 0.05rem 0.5rem;
        font-size: 0.74rem;
        font-weight: 800;
    }

    .analytics-filter-panel {
        position: absolute;
        top: calc(100% + 0.5rem);
        left: 0;
        z-index: 30;
        background: #fff;
        border: 1px solid rgba(16,35,63,0.12);
        border-radius: 12px;
        box-shadow: 0 16px 34px rgba(16,35,63,0.18);
        width: 290px;
        max-width: calc(100vw - 3rem);
        padding: 0.6rem;
    }

    .analytics-filter-search {
        display: flex;
        align-items: center;
        gap: 0.45rem;
        background: #f4f6fb;
        border: 1px solid rgba(16,35,63,0.1);
        border-radius: 8px;
        padding: 0.4rem 0.6rem;
        color: var(--admin-muted);
    }

    .analytics-filter-search:focus-within { border-color: var(--admin-blue); }

    .analytics-filter-search input {
        flex: 1;
        min-width: 0;
        border: none;
        background: none;
        outline: none;
        font-family: 'Nunito Sans', sans-serif;
        font-size: 0.82rem;
        color: var(--admin-ink);
    }

    .analytics-filter-actions {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0.35rem 0.4rem;
        margin-bottom: 0.3rem;
        border-bottom: 1px solid rgba(16,35,63,0.08);
    }

    .analytics-link-btn {
        background: none;
        border: none;
        color: var(--admin-blue);
        font-family: 'Nunito Sans', sans-serif;
        font-size: 0.76rem;
        font-weight: 700;
        cursor: pointer;
        padding: 0.2rem 0.15rem;
    }

    .analytics-link-btn:hover { text-decoration: underline; }

    .analytics-filter-list {
        max-height: 240px;
        overflow-y: auto;
    }

    .analytics-filter-item {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.42rem 0.45rem;
        border-radius: 6px;
        font-size: 0.82rem;
        color: var(--admin-ink);
        cursor: pointer;
    }

    .analytics-filter-item:hover { background: #f4f6fb; }

    .analytics-filter-item input {
        accent-color: var(--admin-blue);
        width: 15px;
        height: 15px;
        cursor: pointer;
        flex-shrink: 0;
    }

    .analytics-filter-name { flex: 1; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    .analytics-filter-n {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--admin-muted);
    }

    .analytics-filter-empty {
        padding: 0.8rem 0.45rem;
        font-size: 0.8rem;
        color: var(--admin-muted);
        text-align: center;
    }

    .analytics-chips {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        flex-wrap: wrap;
        min-width: 0;
        font-size: 0.8rem;
        color: var(--admin-muted);
    }

    .analytics-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        max-width: 220px;
        background: rgba(9,16,122,0.07);
        color: var(--admin-blue);
        border-radius: 999px;
        padding: 0.25rem 0.35rem 0.25rem 0.7rem;
        font-weight: 700;
    }

    .analytics-chip span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    .analytics-chip button {
        display: inline-flex;
        background: none;
        border: none;
        color: inherit;
        cursor: pointer;
        padding: 0.1rem;
        border-radius: 50%;
        opacity: 0.6;
    }

    .analytics-chip button:hover { opacity: 1; background: rgba(9,16,122,0.1); }

    .analytics-chart-empty {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 1rem;
        background: rgba(255,255,255,0.92);
        border-radius: 10px;
        font-size: 0.86rem;
        font-weight: 600;
        color: var(--admin-muted);
        z-index: 1;
    }

    .analytics-scroll {
        max-height: 460px;
        overflow-y: auto;
        position: relative;
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

                        {{-- Program Filter (applies to every chart) --}}
                        <div class="admin-card analytics-toolbar">
                            <div class="analytics-filter" @click.outside="filterOpen = false">
                                <button type="button" class="analytics-filter-btn" @click="toggleFilterPanel()">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h18l-7 8.5V19l-4 2v-8.5L3 4z"/></svg>
                                    Filter programs
                                    <span class="analytics-filter-count" x-text="selected.length + '/' + programs.length"></span>
                                </button>
                                <div class="analytics-filter-panel" x-show="filterOpen" x-cloak x-transition>
                                    <div class="analytics-filter-search">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="M20 20l-3.5-3.5"/></svg>
                                        <input type="text" x-ref="filterSearch" x-model="filterSearch" placeholder="Search programs...">
                                        <button type="button" class="analytics-link-btn" x-show="filterSearch" @click="filterSearch = ''" aria-label="Clear search">&times;</button>
                                    </div>
                                    <div class="analytics-filter-actions">
                                        <button type="button" class="analytics-link-btn" @click="selectAll()" x-text="filterSearch ? 'Select matches' : 'Select all'"></button>
                                        <button type="button" class="analytics-link-btn" @click="deselectAll()" x-text="filterSearch ? 'Deselect matches' : 'Deselect all'"></button>
                                    </div>
                                    <div class="analytics-filter-list">
                                        <template x-for="program in filteredPrograms" :key="program.name">
                                            <label class="analytics-filter-item">
                                                <input type="checkbox" :checked="selected.includes(program.name)" @change="toggleProgram(program.name)">
                                                <span class="analytics-filter-name" x-text="program.name" :title="program.name"></span>
                                                <span class="analytics-filter-n" x-text="program.count"></span>
                                            </label>
                                        </template>
                                        <p class="analytics-filter-empty" x-show="filteredPrograms.length === 0">No programs match your search.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="analytics-chips">
                                <template x-if="selected.length === programs.length">
                                    <span>Showing all programs</span>
                                </template>
                                <template x-if="selected.length === 0">
                                    <span>No programs selected</span>
                                </template>
                                <template x-if="selected.length > 0 && selected.length < programs.length">
                                    <div class="analytics-chips">
                                        <template x-for="name in selectedOrdered.slice(0, 3)" :key="name">
                                            <span class="analytics-chip">
                                                <span x-text="name" :title="name"></span>
                                                <button type="button" @click="toggleProgram(name)" :aria-label="'Remove ' + name">
                                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </span>
                                        </template>
                                        <button type="button" class="analytics-link-btn" x-show="selected.length > 3" @click="toggleFilterPanel()" x-text="'+' + (selected.length - 3) + ' more'"></button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Employment Status Overview --}}
                        <div class="admin-card p-6">
                            <h2 class="analytics-section-title">Employment Status Overview</h2>
                            <p class="analytics-section-desc">Breakdown of alumni respondents by current employment status</p>
                            <div class="mt-5 grid grid-cols-1 lg:grid-cols-[280px_1fr] gap-6 items-center">
                                <div style="position:relative;height:260px;">
                                    <canvas id="employmentChart"></canvas>
                                    <div class="analytics-chart-empty" x-show="!employmentHasData" x-text="emptyMessage"></div>
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
                            <div class="mt-5" style="position:relative;">
                                <div class="analytics-scroll">
                                    <div :style="'position:relative;height:' + alignmentChartHeight + 'px;'">
                                        <canvas id="alignmentChart"></canvas>
                                    </div>
                                </div>
                                <div class="analytics-chart-empty" x-show="!alignmentHasData" x-text="emptyMessage"></div>
                            </div>
                        </div>

                        {{-- Monthly Income Distribution --}}
                        <div class="admin-card p-6">
                            <h2 class="analytics-section-title">Monthly Income Distribution</h2>
                            <p class="analytics-section-desc">First job vs. Current job monthly income comparison</p>
                            <div class="mt-5" style="position:relative;height:320px;">
                                <canvas id="incomeChart"></canvas>
                                <div class="analytics-chart-empty" x-show="!incomeHasData" x-text="emptyMessage"></div>
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
    // Chart.js instances live outside Alpine's reactive proxy.
    const charts = {};

    return {
        programs: @json($programs),
        employmentByProgram: @json($employmentByProgram),
        alignmentByProgram: @json($alignmentByProgram),
        incomeByProgram: @json($incomeByProgram),
        incomeBrackets: @json($incomeBrackets),

        selected: [],
        filterOpen: false,
        filterSearch: '',

        colors: {
            'Employed': '#09107a',
            'Self-employed/Entrepreneur': '#f5b800',
            'Pursuing Further Studies': '#1a24d2',
            'Unemployed': '#c53030',
            'Not Seeking Employment': '#5a6b86',
        },

        // ── Program filter (one selection drives every chart) ──
        get filteredPrograms() {
            const q = this.filterSearch.trim().toLowerCase();
            return q ? this.programs.filter(p => p.name.toLowerCase().includes(q)) : this.programs;
        },

        get selectedOrdered() {
            return this.programs.map(p => p.name).filter(name => this.selected.includes(name));
        },

        get emptyMessage() {
            return this.selected.length === 0
                ? 'Select at least one program to see data.'
                : 'No data for the selected programs.';
        },

        toggleFilterPanel() {
            this.filterOpen = !this.filterOpen;
            if (this.filterOpen) this.$nextTick(() => this.$refs.filterSearch.focus());
        },

        toggleProgram(name) {
            const idx = this.selected.indexOf(name);
            if (idx > -1) this.selected.splice(idx, 1);
            else this.selected.push(name);
            this.refreshCharts();
        },

        // Both act on the current search results, so "search + select all" adds just the matches.
        selectAll() {
            const names = this.filteredPrograms.map(p => p.name);
            this.selected = [...new Set([...this.selected, ...names])];
            this.refreshCharts();
        },

        deselectAll() {
            const names = this.filteredPrograms.map(p => p.name);
            this.selected = this.selected.filter(name => !names.includes(name));
            this.refreshCharts();
        },

        selectedIn(source) {
            return this.selectedOrdered.filter(name => name in source);
        },

        refreshCharts() {
            const builders = {
                employment: () => this.employmentChartData(),
                alignment: () => this.alignmentChartData(),
                income: () => this.incomeChartData(),
            };
            Object.entries(builders).forEach(([key, build]) => {
                if (!charts[key]) return;
                charts[key].data = build();
                charts[key].update();
            });
            this.$nextTick(() => charts.alignment && charts.alignment.resize());
        },

        // ── Employment ──
        get totalRespondents() {
            return this.programs.reduce((sum, p) => sum + p.count, 0);
        },

        get employmentHasData() {
            return this.employmentLegend.some(i => i.count > 0);
        },

        get employmentLegend() {
            const totals = {};
            Object.keys(this.colors).forEach(label => { totals[label] = 0; });
            this.selectedIn(this.employmentByProgram).forEach(p => {
                Object.entries(this.employmentByProgram[p]).forEach(([label, count]) => { totals[label] += count; });
            });
            const total = Object.values(totals).reduce((a, b) => a + b, 0);
            return Object.entries(totals).map(([label, count]) => ({
                label,
                count,
                pct: total > 0 ? Math.round((count / total) * 1000) / 10 : 0,
                color: this.colors[label],
            }));
        },

        employmentChartData() {
            const legend = this.employmentLegend;
            return {
                labels: legend.map(i => i.label),
                datasets: [{
                    data: legend.map(i => i.count),
                    backgroundColor: legend.map(i => i.color),
                    borderWidth: 2,
                    borderColor: '#fff',
                }],
            };
        },

        // ── Alignment ──
        get alignmentChartHeight() {
            return Math.max(180, this.selectedIn(this.alignmentByProgram).length * 56);
        },

        get alignmentHasData() {
            return this.selectedIn(this.alignmentByProgram).length > 0;
        },

        alignmentChartData() {
            const programs = this.selectedIn(this.alignmentByProgram);
            return {
                labels: programs,
                datasets: [
                    { label: 'Aligned', data: programs.map(p => this.alignmentByProgram[p]['Aligned']), backgroundColor: '#09107a' },
                    { label: 'Partially Aligned', data: programs.map(p => this.alignmentByProgram[p]['Partially Aligned']), backgroundColor: '#f5b800' },
                    { label: 'Not Aligned', data: programs.map(p => this.alignmentByProgram[p]['Not Aligned']), backgroundColor: '#c53030' },
                ],
            };
        },

        // ── Income ──
        get incomeHasData() {
            return this.selectedIn(this.incomeByProgram).length > 0;
        },

        incomeChartData() {
            const first = this.incomeBrackets.map(() => 0);
            const current = this.incomeBrackets.map(() => 0);
            this.selectedIn(this.incomeByProgram).forEach(p => {
                this.incomeByProgram[p].first.forEach((n, i) => { first[i] += n; });
                this.incomeByProgram[p].current.forEach((n, i) => { current[i] += n; });
            });
            return {
                labels: this.incomeBrackets,
                datasets: [
                    { label: 'First Job', data: first, backgroundColor: '#f5b800', borderRadius: 6, maxBarThickness: 42 },
                    { label: 'Current Job', data: current, backgroundColor: '#09107a', borderRadius: 6, maxBarThickness: 42 },
                ],
            };
        },

        init() {
            this.selected = this.programs.map(p => p.name);

            if (this.totalRespondents === 0) return;

            this.$nextTick(() => {
                charts.employment = new Chart(document.getElementById('employmentChart'), {
                    type: 'doughnut',
                    data: this.employmentChartData(),
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '62%',
                        plugins: { legend: { display: false } },
                    },
                });

                charts.alignment = new Chart(document.getElementById('alignmentChart'), {
                    type: 'bar',
                    data: this.alignmentChartData(),
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

                charts.income = new Chart(document.getElementById('incomeChart'), {
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
