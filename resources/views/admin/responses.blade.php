@extends('layouts.app')

@section('title', 'Responses - Admin')

@section('content')
<style>
    .admin-shell {
        --admin-blue: #003087;
        --admin-blue-deep: #001f57;
        --admin-gold: #f5b800;
        --admin-ink: #10233f;
        --admin-muted: #5a6b86;
        min-height: 100vh;
        background:
            radial-gradient(circle at top left, rgba(0, 48, 135, 0.10), transparent 28%),
            radial-gradient(circle at bottom right, rgba(245, 184, 0, 0.10), transparent 24%),
            linear-gradient(180deg, #f5f7fb 0%, #eef3fb 100%);
    }

    .admin-topbar {
        background: #09107a;
        border-bottom: 1px solid rgba(255,255,255,0.08);
        box-shadow: 0 2px 12px rgba(0,0,0,0.2);
    }

    .admin-heading {
        color: #fff;
        font-weight: 800;
        font-size: 1rem !important;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .admin-subtle { display: none; }

    .admin-back-btn,
    .admin-tab-btn,
    .admin-action-btn,
    .admin-icon-btn {
        border-radius: 12px;
        font-weight: 700;
        transition: all 0.2s ease;
    }

    .admin-back-btn {
        background: rgba(255,255,255,0.12);
        color: #fff;
        border: 1.5px solid rgba(255,255,255,0.3);
        box-shadow: none;
    }

    .admin-back-btn:hover {
        background: rgba(255,255,255,0.2);
        border-color: rgba(255,255,255,0.6);
    }

    .admin-tab-shell {
        border-bottom: none;
        background: rgba(255,255,255,0.06);
    }

    .admin-tab-btn {
        padding: 0.7rem 1rem;
        border-bottom: 3px solid transparent;
        font-size: 0.85rem;
    }

    .admin-tab-btn.active {
        color: #fff;
        border-bottom-color: var(--admin-gold);
    }

    .admin-tab-btn.inactive {
        color: rgba(255,255,255,0.55);
    }

    .admin-tab-btn.inactive:hover {
        color: rgba(255,255,255,0.85);
        border-bottom-color: rgba(255,255,255,0.25);
    }

    .admin-panel,
    .admin-card,
    .admin-empty-state,
    .response-row,
    .detail-panel {
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid rgba(16, 35, 63, 0.10);
        border-radius: 18px;
        box-shadow: 0 14px 30px rgba(16, 35, 63, 0.07);
    }

    .admin-hero {
        background: linear-gradient(135deg, var(--admin-blue) 0%, #0a4cc1 60%, #1e5bd3 100%);
        color: white;
        border-radius: 18px;
        box-shadow: 0 18px 38px rgba(0, 48, 135, 0.28);
    }

    .admin-hero .muted {
        color: rgba(255, 255, 255, 0.85);
    }

    .admin-section-label {
        color: var(--admin-blue);
        font-size: 0.95rem;
        font-weight: 800;
        letter-spacing: 0.02em;
    }

    .admin-action-btn {
        background: linear-gradient(90deg, var(--admin-blue) 0%, var(--admin-blue-deep) 100%);
        color: #fff;
        box-shadow: 0 10px 20px rgba(0, 48, 135, 0.22);
    }

    .admin-action-btn:hover {
        background: linear-gradient(90deg, var(--admin-blue-deep) 0%, #001844 100%);
    }

    .admin-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border-radius: 9999px;
        padding: 0.35rem 0.7rem;
        font-size: 0.8rem;
        font-weight: 800;
    }

    .admin-badge.blue {
        background: rgba(0, 48, 135, 0.12);
        color: var(--admin-blue);
    }

    .admin-badge.gold {
        background: rgba(245, 184, 0, 0.18);
        color: #7a5900;
    }

    .response-table-head {
        background: linear-gradient(180deg, #f9fbff, #eef4ff);
        border-bottom: 1px solid rgba(16, 35, 63, 0.08);
    }

    .response-row:hover {
        background: #f7faff;
    }

    .response-row.selected {
        background: linear-gradient(90deg, rgba(0, 48, 135, 0.08), rgba(245, 184, 0, 0.08));
        border-left: 4px solid var(--admin-blue);
    }

    .response-id {
        color: #10233f;
        font-weight: 700;
        word-break: break-all;
    }

    .response-muted {
        color: var(--admin-muted);
    }

    .response-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        border-radius: 9999px;
        padding: 0.35rem 0.7rem;
        font-size: 0.75rem;
        font-weight: 800;
        background: rgba(0, 48, 135, 0.08);
        color: var(--admin-blue);
    }

    .response-view-btn {
        background: linear-gradient(90deg, var(--admin-blue) 0%, var(--admin-blue-deep) 100%);
        color: #fff;
        border-radius: 10px;
        box-shadow: 0 10px 20px rgba(0, 48, 135, 0.22);
        font-weight: 700;
    }

    .response-view-btn:hover {
        background: linear-gradient(90deg, var(--admin-blue-deep) 0%, #001844 100%);
    }

    .detail-panel {
        background: linear-gradient(180deg, #ffffff, #f8fbff);
    }
</style>

<div class="admin-shell" x-data="responsesApp()" x-cloak>
    {{-- Admin Header --}}
    <div class="admin-topbar sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/ADDU-SEAL-Colored.png') }}" alt="" class="w-7 h-7 rounded-full opacity-90" onerror="this.style.display='none'">
                        <h1 class="admin-heading">Tracer Study Admin</h1>
                    </div>
                </div>
                <a href="/" class="admin-back-btn flex items-center gap-2 px-4 py-2 whitespace-nowrap text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Back to Site
                </a>
            </div>
        </div>

        {{-- Navigation Tabs --}}
        <div class="admin-tab-shell">
            <nav class="max-w-7xl mx-auto px-6 flex gap-1 -mb-px overflow-x-auto">
                <a href="/admin"
                   class="admin-tab-btn inactive whitespace-nowrap">
                    Dashboard
                </a>
                <a href="/admin/responses"
                   class="admin-tab-btn active whitespace-nowrap">
                    Responses
                </a>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="admin-panel p-8">
            {{-- Header --}}
            <div class="admin-hero p-6 mb-8">
                <div class="flex items-center justify-between gap-4 flex-wrap">
                <div>
                    <h1 class="text-3xl font-extrabold mb-2">Survey Responses</h1>
                    <p class="muted text-sm" x-text="responses.length + ' total submission' + (responses.length !== 1 ? 's' : '')"></p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="admin-badge blue">Submitted records</span>
                        <span class="admin-badge gold">Exportable CSV</span>
                    </div>
                </div>
                <template x-if="responses.length > 0">
                    <a href="/admin/export-csv" class="admin-action-btn flex items-center gap-2 px-4 py-2 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Export CSV
                    </a>
                </template>
                </div>
            </div>

            <template x-if="responses.length === 0">
                <div class="admin-empty-state text-center py-20">
                    <svg class="w-16 h-16 mx-auto mb-4 text-[#003087] opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <h2 class="text-xl font-extrabold text-[#10233f] mb-1">No responses yet</h2>
                    <p class="text-sm response-muted">Responses will appear here once someone submits the survey.</p>
                </div>
            </template>

            <template x-if="responses.length > 0">
                <div class="admin-card overflow-hidden">
                    {{-- Table Header --}}
                    <div class="response-table-head grid grid-cols-[60px_1fr_200px_100px] gap-4 px-6 py-3 text-xs font-semibold uppercase tracking-wider text-[#5a6b86]">
                        <span>#</span>
                        <span>Response ID</span>
                        <button class="flex items-center gap-1 hover:text-[#003087] transition-colors" @click="sortAsc = !sortAsc">
                            Submitted
                            <template x-if="sortAsc">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                            </template>
                            <template x-if="!sortAsc">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </template>
                        </button>
                        <span class="text-center">View</span>
                    </div>

                    {{-- Rows --}}
                    <template x-for="(r, i) in sortedResponses" :key="r.id">
                        <div>
                            <div
                                :class="selectedResponse === r.id ? 'response-row selected' : 'response-row'"
                                class="grid grid-cols-[60px_1fr_200px_100px] gap-4 px-6 py-4 border-b border-slate-100 items-center"
                            >
                                <span class="text-sm text-[#5a6b86] font-semibold" x-text="i + 1"></span>
                                <span class="text-sm font-mono response-id truncate" x-text="r.id"></span>
                                <span class="text-sm response-muted" x-text="formatDate(r.submitted_at)"></span>
                                <div class="text-center">
                                    <button
                                        @click="viewResponse(r.id)"
                                        class="response-view-btn inline-flex items-center gap-1 px-3 py-1 text-xs"
                                    >
                                        <template x-if="selectedResponse === r.id">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                Close
                                            </span>
                                        </template>
                                        <template x-if="selectedResponse !== r.id">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                View
                                            </span>
                                        </template>
                                    </button>
                                </div>
                            </div>

                            {{-- Expanded detail --}}
                            <template x-if="selectedResponse === r.id">
                                <div class="detail-panel px-6 py-6 border-b border-slate-200">
                                    <template x-if="detailsLoading">
                                        <p class="text-sm response-muted">Loading answers...</p>
                                    </template>
                                    <template x-if="!detailsLoading && responseDetails.length === 0">
                                        <p class="text-sm response-muted">No answers recorded for this response.</p>
                                    </template>
                                    <template x-if="!detailsLoading && responseDetails.length > 0">
                                        <div class="space-y-4">
                                            <template x-for="group in groupedDetails" :key="group.title">
                                                <div>
                                                    <h3 class="text-xs font-extrabold text-[#003087] uppercase tracking-wider mb-2 border-b border-blue-100 pb-1" x-text="group.title"></h3>
                                                    <div class="space-y-1">
                                                        <template x-for="item in group.items" :key="item.id">
                                                            <div class="grid grid-cols-[1fr_1fr] gap-4 py-2 text-sm">
                                                                <span class="response-muted" x-text="item.question_text"></span>
                                                                <span class="font-semibold text-[#10233f]" x-text="formatAnswer(item)"></span>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
function responsesApp() {
    return {
        responses: @json($responses),
        selectedResponse: null,
        responseDetails: [],
        detailsLoading: false,
        sortAsc: false,

        get sortedResponses() {
            return [...this.responses].sort((a, b) => {
                const da = new Date(a.submitted_at).getTime();
                const db = new Date(b.submitted_at).getTime();
                return this.sortAsc ? da - db : db - da;
            });
        },

        get groupedDetails() {
            const grouped = {};
            for (const ra of this.responseDetails) {
                const cat = ra.category_title || 'Unknown';
                if (!grouped[cat]) grouped[cat] = [];
                grouped[cat].push(ra);
            }
            return Object.entries(grouped).map(([title, items]) => ({ title, items }));
        },

        formatDate(dateStr) {
            return new Date(dateStr).toLocaleString('en-PH', {
                year: 'numeric', month: 'short', day: 'numeric',
                hour: '2-digit', minute: '2-digit',
            });
        },

        formatAnswer(ra) {
            if (ra.values && ra.values.length > 0) return ra.values.join(', ');
            return ra.value || '—';
        },

        async viewResponse(responseId) {
            if (this.selectedResponse === responseId) {
                this.selectedResponse = null;
                return;
            }

            this.detailsLoading = true;
            this.selectedResponse = responseId;

            try {
                const res = await fetch('/admin/responses/' + responseId + '/details');
                this.responseDetails = await res.json();
            } catch {
                this.responseDetails = [];
            }
            this.detailsLoading = false;
        },
    };
}
</script>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection
