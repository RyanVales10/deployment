@extends('layouts.app')

@section('title', 'Admin - Tracer Study')

@section('content')
<style>
    @import url('https://fonts.bunny.net/css?family=cinzel:400,700,800|nunito-sans:300,400,500,600,700,800');

    .admin-shell {
        --admin-blue: #09107a;
        --admin-blue-deep: #060c52;
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

    .admin-heading {
        font-family: 'Cinzel', serif;
        color: #fff;
        font-weight: 700;
        font-size: 0.95rem !important;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    .admin-subtle { display: none; }

    .admin-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        border-radius: 8px;
        font-weight: 700;
        font-family: 'Nunito Sans', sans-serif;
        font-size: 0.82rem;
        transition: all 0.15s;
        background: #fff;
        color: #09107a;
        border: none;
        padding: 0.4rem 0.9rem;
        text-decoration: none;
        white-space: nowrap;
    }

    .admin-back-btn:hover {
        background: #e8edf6;
    }

    /* White tab bar below topbar */
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

    .admin-tab-btn.inactive {
        color: #6b7a99;
    }

    .admin-tab-btn.inactive:hover {
        color: #09107a;
        border-bottom-color: rgba(9,16,122,0.3);
    }

    .admin-panel,
    .admin-card,
    .admin-empty-state,
    .question-card {
        background: rgba(255, 255, 255, 0.96);
        border: 1px solid rgba(16, 35, 63, 0.10);
        border-radius: 18px;
        box-shadow: 0 14px 30px rgba(16, 35, 63, 0.07);
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

    .admin-hero-badge span {
        color: var(--admin-gold);
        font-weight: 800;
    }

    .admin-hero-badge-label { font-weight: 700; }

    .admin-section-label {
        font-family: 'Nunito Sans', sans-serif;
        color: var(--admin-ink);
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.1em;
        text-transform: uppercase;
    }

    .admin-action-btn {
        background: #09107a;
        color: #fff;
        border-radius: 999px;
        font-family: 'Nunito Sans', sans-serif;
        font-size: 0.82rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: background 0.15s;
    }

    .admin-action-btn:hover { background: #1a24d2; }

    .admin-warning-btn {
        background: linear-gradient(90deg, #d97706 0%, #b45309 100%);
        color: #fff;
    }

    .admin-danger-btn {
        background: linear-gradient(90deg, #c53030 0%, #9b1c1c 100%);
        color: #fff;
    }

    .admin-list-item {
        border-bottom: 1px solid rgba(16, 35, 63, 0.06);
        transition: background 0.2s ease;
    }

    .admin-list-item:hover {
        background: #f7faff;
    }

    .admin-list-item.selected {
        background: linear-gradient(90deg, rgba(0, 48, 135, 0.08), rgba(245, 184, 0, 0.08));
        border-left: 4px solid var(--admin-blue);
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
</style>

<div class="admin-shell" x-data="adminApp()" x-cloak>
    {{-- Admin Header --}}
    <div class="admin-topbar sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex items-center justify-between gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-2.5">
                        <img src="{{ asset('images/ADDU-SEAL-Colored.png') }}" alt="" class="w-8 h-8 rounded-full opacity-90" onerror="this.style.display='none'">
                        <div>
                            <h1 class="admin-heading" style="line-height:1.1;">Tracer Study Admin</h1>
                            <p style="font-family:'Nunito Sans',sans-serif;font-size:0.7rem;color:rgba(255,255,255,0.55);letter-spacing:0.03em;margin:0;line-height:1.2;">Alumni Affairs Office</p>
                        </div>
                    </div>
                </div>
                <a href="/" class="admin-back-btn flex items-center gap-2 px-4 py-2 whitespace-nowrap text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Home
                </a>
            </div>
        </div>

        {{-- Navigation Tabs --}}
        <div class="admin-tab-shell">
            <nav class="max-w-7xl mx-auto px-6 flex gap-1 -mb-px overflow-x-auto">
                <a href="/admin"
                   class="admin-tab-btn active whitespace-nowrap">
                    Dashboard
                </a>
                <a href="/admin/responses"
                   class="admin-tab-btn inactive whitespace-nowrap">
                    Responses
                </a>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="admin-panel overflow-hidden">
            {{-- Tracer Study Management Header --}}
            <div class="admin-hero mb-0">
                <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <p class="admin-hero-eyebrow">Survey Management</p>
                        <h1>Tracer Study Management</h1>
                        <p class="muted">Create and manage survey categories, questions, and answer options</p>
                    </div>
                    <div class="admin-hero-badges">
                        <div class="admin-hero-badge">
                            Categories <span x-text="categories.length"></span>
                        </div>
                        <div class="admin-hero-badge">
                            Questions <span x-text="totalQuestions"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-8 pb-8 pt-3">
            {{-- Tabs --}}
            <div class="mb-6 border-b border-slate-200">
                <div class="flex gap-6">
                    <button
                        @click="activeTab = 'categories'"
                        :class="activeTab === 'categories' ? 'admin-tab-btn active' : 'admin-tab-btn inactive'"
                        class=""
                    >
                        Manage Categories & Questions
                    </button>
                    <button
                        @click="activeTab = 'preview'"
                        :class="activeTab === 'preview' ? 'admin-tab-btn active' : 'admin-tab-btn inactive'"
                        class="flex items-center gap-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Preview Survey
                    </button>
                </div>
            </div>

            {{-- Categories Tab --}}
            <template x-if="activeTab === 'categories'">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {{-- Left Column - Categories --}}
                    <div class="lg:col-span-1">
                        <div class="admin-card overflow-hidden">
                            <div class="p-4 border-b border-slate-200 bg-gradient-to-r from-white to-slate-50">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="admin-section-label">Categories</h2>
                                    <button
                                        @click="isEditingCategory = true; selectedCategory = null; categoryForm = { title: '', description: '' }"
                                        class="admin-action-btn flex items-center gap-2 px-3 py-2 text-sm"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Add Category
                                    </button>
                                </div>

                                {{-- Category Form --}}
                                <template x-if="isEditingCategory">
                                    <div class="mb-4 p-4 rounded-xl space-y-3" style="background: linear-gradient(180deg, rgba(0,48,135,0.06), rgba(245,184,0,0.06)); border: 1px solid rgba(0,48,135,0.14);">
                                        <div>
                                            <label class="block text-xs font-bold mb-1 text-[#10233f]">Category Title</label>
                                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white" placeholder="e.g., Basic Information" x-model="categoryForm.title">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold mb-1 text-[#10233f]">Description</label>
                                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white" placeholder="Brief description" rows="2" x-model="categoryForm.description"></textarea>
                                        </div>
                                        <div class="flex gap-2">
                                            <button @click="saveCategory()" class="admin-action-btn flex-1 flex items-center justify-center gap-2 px-3 py-2 text-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                                <span x-text="editingCategoryId ? 'Update' : 'Save'"></span>
                                            </button>
                                            <button @click="isEditingCategory = false; editingCategoryId = null; categoryForm = { title: '', description: '' }" class="px-3 py-2 bg-slate-200 text-slate-800 rounded-lg text-sm hover:bg-slate-300 transition-colors font-semibold">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            {{-- Category List --}}
                            <div class="divide-y divide-slate-200 max-h-[600px] overflow-y-auto">
                                <template x-if="categories.length === 0">
                                    <div class="admin-empty-state p-8 text-center">
                                        <svg class="w-12 h-12 mx-auto mb-3 opacity-30 text-[#003087]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <p class="text-sm font-semibold text-[#10233f]">No categories yet</p>
                                        <p class="text-xs text-[#5a6b86]">Click "Add Category" to get started</p>
                                    </div>
                                </template>
                                <template x-for="category in categories" :key="category.id">
                                    <div
                                        :class="selectedCategory?.id === category.id ? 'admin-list-item selected' : 'admin-list-item'"
                                        class="p-4 cursor-pointer"
                                        @click="selectedCategory = category"
                                    >
                                        <div class="flex items-start justify-between gap-2">
                                            <div class="flex items-start gap-3 flex-1">
                                                <svg class="w-4 h-4 text-[#003087] mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                                <div class="flex-1 min-w-0">
                                                    <h3 class="font-semibold text-sm mb-1 text-[#10233f]" x-text="category.title"></h3>
                                                    <p class="text-xs text-[#5a6b86] line-clamp-2" x-text="category.description"></p>
                                                    <p class="text-xs mt-2 text-[#003087] font-semibold" x-text="category.questions.length + ' question' + (category.questions.length !== 1 ? 's' : '')"></p>
                                                </div>
                                            </div>
                                            <div class="flex gap-1 flex-shrink-0">
                                                <button @click.stop="editCategory(category)" class="admin-icon-btn p-1.5 text-[#003087] hover:bg-blue-100 rounded">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                                <button @click.stop="deleteCategory(category.id)" class="admin-icon-btn p-1.5 text-red-600 hover:bg-red-100 rounded">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- Right Column - Questions --}}
                    <div class="lg:col-span-2">
                        <template x-if="selectedCategory">
                            <div class="admin-card overflow-hidden">
                                <div class="p-4 border-b border-slate-200 bg-gradient-to-r from-white to-slate-50">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h2 class="admin-section-label mb-1" x-text="selectedCategory.title"></h2>
                                            <p class="text-sm text-[#5a6b86]" x-text="selectedCategory.description"></p>
                                        </div>
                                        <button
                                            @click="isEditingQuestion = true; editingQuestionId = null; questionForm = { text: '', type: 'text', required: false, answers: [], placeholder: 'Region XI', help_text: '', condition_question_id: '', condition_operator: 'notEmpty', condition_value: '' }"
                                            class="admin-action-btn flex items-center gap-2 px-4 py-2 text-sm"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Add Question
                                        </button>
                                    </div>

                                    {{-- Question Form --}}
                                    <template x-if="isEditingQuestion">
                                        <div class="p-4 rounded-xl space-y-4" style="background: linear-gradient(180deg, rgba(0,48,135,0.06), rgba(245,184,0,0.06)); border: 1px solid rgba(0,48,135,0.14);">
                                            <div>
                                                <label class="block text-sm font-bold mb-2 text-[#10233f]">Question Text</label>
                                                <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white" placeholder="Enter your question here..." rows="2" x-model="questionForm.text"></textarea>
                                            </div>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-bold mb-2 text-[#10233f]">Question Type</label>
                                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white" x-model="questionForm.type">
                                                        <option value="text">Short Text</option>
                                                        <option value="textarea">Long Text</option>
                                                        <option value="display">Display Text (No Input)</option>
                                                        <option value="radio">Single Choice (Radio)</option>
                                                        <option value="checkbox">Multiple Choice (Checkbox)</option>
                                                        <option value="select">Dropdown (Select)</option>
                                                        <option value="number">Number</option>
                                                        <option value="date">Date</option>
                                                        <option value="month">Month/Year</option>
                                                        <option value="country_select">Country Dropdown (API)</option>
                                                        <option value="region_select">Region (PSGC)</option>
                                                        <option value="province_select">Province (PSGC)</option>
                                                        <option value="municipality_select">Municipality / City (PSGC)</option>
                                                        <option value="barangay_select">Barangay (PSGC)</option>
                                                    </select>
                                                </div>
                                                <div class="flex items-end">
                                                    <label class="flex items-center gap-2 cursor-pointer">
                                                        <input type="checkbox" class="w-4 h-4 text-[#003087] rounded" x-model="questionForm.required">
                                                        <span class="text-sm font-bold text-[#10233f]">Required Question</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-bold mb-2 text-[#10233f]" x-text="questionForm.type === 'display' ? 'Display Text' : 'Placeholder Text (optional)'"></label>
                                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white" :placeholder="questionForm.type === 'display' ? 'e.g. Region XI' : 'e.g. Enter your answer here...'" x-model="questionForm.placeholder">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-bold mb-2 text-[#10233f]">Help Text (optional)</label>
                                                <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white" placeholder="Additional guidance for respondents..." x-model="questionForm.help_text">
                                            </div>

                                            <div class="p-4 bg-white border border-gray-200 rounded-xl space-y-4 shadow-sm">
                                                <div>
                                                    <h3 class="text-sm font-extrabold text-[#10233f] mb-1">Visibility Rule</h3>
                                                    <p class="text-xs text-[#5a6b86]">Optional: show this question only when another question meets a condition.</p>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-bold mb-2 text-[#10233f]">Show only if question</label>
                                                    <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white" x-model="questionForm.condition_question_id">
                                                        <option value="">No condition</option>
                                                        <template x-for="candidate in allQuestionsForConditions()" :key="candidate.id">
                                                            <option :value="candidate.id" x-text="candidate.category_title + ' - ' + candidate.text"></option>
                                                        </template>
                                                    </select>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <label class="block text-sm font-bold mb-2 text-[#10233f]">Comparison</label>
                                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white" x-model="questionForm.condition_operator">
                                                            <option value="equals">Equals</option>
                                                            <option value="notEquals">Not equals</option>
                                                            <option value="notEqualsStrict">Not equals (strict)</option>
                                                            <option value="includes">Includes</option>
                                                            <option value="in">In list</option>
                                                            <option value="notEmpty">Is not empty</option>
                                                            <option value="greaterThan">Greater than</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold mb-2 text-[#10233f]">Value to compare against</label>
                                                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white" placeholder="e.g. Philippines, Yes, 18" x-model="questionForm.condition_value">
                                                    </div>
                                                </div>
                                                <p class="text-xs text-[#5a6b86]">Tip: use this to hide follow-up questions until a respondent selects a specific answer.</p>
                                            </div>

                                            {{-- Answer Options --}}
                                            <template x-if="['radio', 'checkbox', 'select'].includes(questionForm.type)">
                                                <div>
                                                    <div class="flex items-center justify-between mb-2">
                                                        <label class="block text-sm font-bold text-[#10233f]">Answer Options</label>
                                                        <button @click="addAnswerOption()" class="admin-action-btn flex items-center gap-1 px-2 py-1 text-xs">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                                            Add Option
                                                        </button>
                                                    </div>
                                                    <div class="space-y-2">
                                                        <template x-for="(answer, idx) in questionForm.answers" :key="idx">
                                                            <div class="flex items-center gap-2">
                                                                <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                                                <input type="text" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm bg-white" placeholder="Answer option text" x-model="answer.text">
                                                                <button @click="questionForm.answers.splice(idx, 1)" class="admin-danger-btn p-2 rounded-lg transition-colors">
                                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                                </button>
                                                            </div>
                                                        </template>
                                                        <template x-if="questionForm.answers.length === 0">
                                                            <p class="text-xs text-[#5a6b86] text-center py-3">No answer options yet. Click "Add Option" to create choices.</p>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                            <div class="flex gap-2">
                                                <button @click="saveQuestion()" class="admin-action-btn flex-1 flex items-center justify-center gap-2 px-4 py-2 text-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                                                    <span x-text="editingQuestionId ? 'Update Question' : 'Save Question'"></span>
                                                </button>
                                                <button @click="isEditingQuestion = false; editingQuestionId = null" class="px-4 py-2 bg-slate-200 text-slate-800 rounded-lg text-sm hover:bg-slate-300 transition-colors font-semibold">Cancel</button>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                {{-- Questions List --}}
                                <div class="divide-y divide-slate-200 max-h-[600px] overflow-y-auto">
                                    <template x-if="selectedCategory.questions.length === 0">
                                        <div class="admin-empty-state p-8 text-center">
                                            <svg class="w-12 h-12 mx-auto mb-3 opacity-30 text-[#003087]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            <p class="text-sm font-semibold text-[#10233f]">No questions in this category yet</p>
                                            <p class="text-xs text-[#5a6b86]">Click "Add Question" to get started</p>
                                        </div>
                                    </template>
                                    <template x-for="(question, index) in selectedCategory.questions.slice().sort((a, b) => a.order - b.order)" :key="question.id">
                                        <div
                                            class="admin-list-item p-4 cursor-move"
                                            :class="draggedQuestionId === question.id ? 'opacity-50' : ''"
                                            draggable="true"
                                            @dragstart="onQuestionDragStart(question.id)"
                                            @dragover.prevent
                                            @drop="onQuestionDrop(question.id)"
                                            @dragend="draggedQuestionId = null"
                                            title="Drag to reorder"
                                        >
                                            <div class="flex items-start gap-3">
                                                <svg class="w-4 h-4 text-[#003087] mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                                                <div class="flex-1 min-w-0">
                                                    <div class="flex items-start gap-2 mb-2">
                                                        <span class="text-xs font-extrabold text-[#003087] mt-1" x-text="'Q' + (index + 1)"></span>
                                                        <div class="flex-1">
                                                            <div class="flex items-start gap-2 mb-1">
                                                                <p class="text-sm flex-1 font-semibold text-[#10233f]" x-text="question.text"></p>
                                                                <template x-if="question.required">
                                                                    <span class="admin-badge" style="background: rgba(197,48,48,0.12); color: #9b1c1c;">Required</span>
                                                                </template>
                                                            </div>
                                                            <template x-if="question.help_text">
                                                                <p class="text-xs text-[#5a6b86] mb-2" x-text="question.help_text"></p>
                                                            </template>
                                                            <template x-if="question.condition_question_id && question.condition_operator">
                                                                <p class="text-xs text-[#003087] mb-2 font-semibold" x-text="conditionSummary(question)"></p>
                                                            </template>
                                                            <div class="flex items-center gap-2 text-xs text-[#5a6b86]">
                                                                <span class="capitalize" x-text="question.type"></span>
                                                                <template x-if="question.answers && question.answers.length > 0">
                                                                    <span>
                                                                        <span>•</span>
                                                                        <span x-text="question.answers.length + ' options'"></span>
                                                                    </span>
                                                                </template>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex gap-1 flex-shrink-0">
                                                    <button @click="editQuestion(question)" class="admin-icon-btn p-1.5 text-[#003087] hover:bg-blue-100 rounded">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                    </button>
                                                    <button @click="deleteQuestion(question.id)" class="admin-icon-btn p-1.5 text-red-600 hover:bg-red-100 rounded">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>

                        <template x-if="!selectedCategory">
                            <div class="admin-empty-state p-12 text-center">
                                <svg class="w-16 h-16 mx-auto mb-4 text-[#003087] opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <h3 class="text-lg font-extrabold mb-2 text-[#10233f]">No Category Selected</h3>
                                <p class="text-sm text-[#5a6b86]">Select a category from the left to manage its questions</p>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            {{-- Preview Tab --}}
            <template x-if="activeTab === 'preview'">
                <div>
                    <div class="mb-6">
                        <h2 class="text-2xl font-extrabold mb-2 text-[#10233f]">Survey Preview</h2>
                        <p class="text-sm text-[#5a6b86]">This is how the survey will appear to respondents</p>
                    </div>

                    <template x-if="previewCategories.length === 0">
                        <div class="admin-empty-state text-center py-12">
                            <svg class="w-16 h-16 mx-auto mb-4 text-[#003087] opacity-25" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p class="font-semibold text-[#10233f]">No categories or questions to preview</p>
                        </div>
                    </template>

                    <div class="mb-4 text-sm text-[#5a6b86]">
                        <span x-text="previewTotalQuestions"></span>
                        <span>questions currently visible in the form preview</span>
                    </div>

                    <div class="space-y-8">
                        <template x-for="(category, catIndex) in previewCategories" :key="category.id">
                            <div class="admin-card overflow-hidden">
                                <div class="mb-6" style="background:linear-gradient(135deg,#09107a 0%,#1a24d2 100%);border-radius:inherit;border-bottom-left-radius:0;border-bottom-right-radius:0;padding:1.5rem 1.75rem;display:flex;align-items:center;justify-content:space-between;">
                                    <div>
                                        <p style="font-family:'Nunito Sans',sans-serif;font-size:0.73rem;font-weight:700;color:#f5b800;letter-spacing:0.14em;text-transform:uppercase;margin:0 0 0.35rem;display:flex;align-items:center;gap:0.5rem;">
                                            <span style="display:inline-block;width:16px;height:2px;background:#f5b800;border-radius:1px;flex-shrink:0;"></span>
                                            <span x-text="'Section ' + (catIndex + 1) + ' of ' + previewCategories.length"></span>
                                        </p>
                                        <h3 style="font-family:'Cinzel',serif;font-size:1.25rem;font-weight:700;color:#fff;letter-spacing:0.03em;margin:0 0 0.35rem;" x-text="category.title.toUpperCase()"></h3>
                                        <p style="font-family:'Nunito Sans',sans-serif;font-size:0.82rem;color:rgba(255,255,255,0.6);margin:0;" x-text="category.description"></p>
                                    </div>
                                    <div style="font-family:'Cinzel',serif;font-size:4rem;font-weight:800;color:rgba(255,255,255,0.1);line-height:1;padding-left:1.5rem;flex-shrink:0;" x-text="String(catIndex + 1).padStart(2,'0')"></div>
                                </div>
                                <div class="p-6">
                                <div class="space-y-6">
                                    <template x-for="question in visiblePreviewQuestions(category)" :key="question.id">
                                        <div class="question-card p-4">
                                            <label class="block text-base font-semibold mb-2 text-[#10233f]">
                                                <span x-text="question.text"></span>
                                                <template x-if="question.required && question.type !== 'display'"><span class="text-red-600 ml-1">*</span></template>
                                            </label>
                                            <template x-if="question.help_text">
                                                <p class="text-xs text-[#5a6b86] mb-2" x-text="question.help_text"></p>
                                            </template>

                                            <template x-if="question.type === 'display'">
                                                <div class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-slate-50 text-[#10233f]" x-text="question.placeholder || 'Region XI'"></div>
                                            </template>

                                            <template x-if="question.type === 'text'">
                                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white" :placeholder="question.placeholder || 'Your answer'" disabled>
                                            </template>
                                            <template x-if="question.type === 'textarea'">
                                                <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-white" :placeholder="question.placeholder || 'Your answer'" rows="3" disabled></textarea>
                                            </template>
                                            <template x-if="question.type === 'number'">
                                                <input type="number" class="w-full md:w-1/3 px-4 py-2 border border-gray-300 rounded-lg bg-white" :placeholder="question.placeholder" disabled>
                                            </template>
                                            <template x-if="question.type === 'date'">
                                                <input type="date" class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg bg-white" disabled>
                                            </template>
                                            <template x-if="question.type === 'month'">
                                                <input type="month" class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg" disabled>
                                            </template>
                                            <template x-if="question.type === 'radio'">
                                                <div class="space-y-2">
                                                    <template x-for="answer in question.answers" :key="answer.id">
                                                        <label class="flex items-center gap-2 cursor-pointer">
                                                            <input type="radio" :name="'preview-' + question.id" class="w-4 h-4" disabled>
                                                            <span class="text-sm" x-text="answer.text"></span>
                                                        </label>
                                                    </template>
                                                </div>
                                            </template>
                                            <template x-if="question.type === 'checkbox'">
                                                <div class="space-y-2">
                                                    <template x-for="answer in question.answers" :key="answer.id">
                                                        <label class="flex items-center gap-2 cursor-pointer">
                                                            <input type="checkbox" class="w-4 h-4 rounded" disabled>
                                                            <span class="text-sm" x-text="answer.text"></span>
                                                        </label>
                                                    </template>
                                                </div>
                                            </template>
                                            <template x-if="question.type === 'select'">
                                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg" disabled>
                                                    <option>Select an option...</option>
                                                    <template x-for="answer in question.answers" :key="answer.id">
                                                        <option x-text="answer.text"></option>
                                                    </template>
                                                </select>
                                            </template>
                                            <template x-if="question.type === 'country_select'">
                                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Search for a country..." disabled>
                                            </template>
                                            <template x-if="question.type === 'region_select'">
                                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Search for a region..." disabled>
                                            </template>
                                            <template x-if="question.type === 'province_select'">
                                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Search for a province..." disabled>
                                            </template>
                                            <template x-if="question.type === 'municipality_select'">
                                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Search for a municipality/city..." disabled>
                                            </template>
                                            <template x-if="question.type === 'barangay_select'">
                                                <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-lg" placeholder="Search for a barangay..." disabled>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                                </div>{{-- /p-6 --}}
                            </div>
                        </template>
                    </div>
                </div>
            </template>
            </div>{{-- /p-8 --}}
        </div>
    </div>
</div>

<script>
function adminApp() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const previewCategories = @json($previewCategories);

    return {
        categories: @json($categories),
        previewCategories: previewCategories.sort((a, b) => a.order - b.order),
        previewFormData: {},
        selectedCategory: null,
        activeTab: 'categories',
        isEditingCategory: false,
        editingCategoryId: null,
        categoryForm: { title: '', description: '' },
        isEditingQuestion: false,
        editingQuestionId: null,
        questionForm: { text: '', type: 'text', required: false, answers: [], placeholder: 'Region XI', help_text: '' },
            draggedQuestionId: null,

        get totalQuestions() {
            return this.categories.reduce((t, c) => t + c.questions.length, 0);
        },

        allQuestionsForConditions() {
            const currentQuestionId = this.editingQuestionId;
            return this.categories.flatMap(category =>
                (category.questions || [])
                    .slice()
                    .sort((a, b) => a.order - b.order)
                    .filter(question => question.id !== currentQuestionId)
                    .map(question => ({
                        ...question,
                        category_title: category.title,
                    }))
            );
        },

        conditionQuestionText(questionId) {
            for (const category of this.categories) {
                const found = (category.questions || []).find(question => question.id === questionId);
                if (found) return found.text;
            }
            return '';
        },

        conditionSummary(question) {
            const field = this.conditionQuestionText(question.condition_question_id);
            const opLabels = {
                equals: 'equals',
                notEquals: 'does not equal',
                notEqualsStrict: 'is not exactly',
                includes: 'includes',
                in: 'is in',
                notEmpty: 'is not empty',
                greaterThan: 'is greater than',
            };

            const operator = opLabels[question.condition_operator] || question.condition_operator;
            const value = question.condition_value ? ` ${question.condition_value}` : '';
            return `Visible only when "${field || 'Unknown question'}" ${operator}${value}`;
        },

        get previewTotalQuestions() {
            return this.previewCategories.reduce((t, category) => t + this.visiblePreviewQuestions(category).length, 0);
        },

        visiblePreviewQuestions(category) {
            if (!category) return [];

            return (category.questions || [])
                .slice()
                .sort((a, b) => a.order - b.order)
                .filter(question => this.isPreviewConditionMet(question));
        },

        findPreviewQuestionIdByRef(ref) {
            for (const category of this.previewCategories) {
                for (const question of category.questions || []) {
                    if (question.ref === ref) return question.id;
                }
            }
            return null;
        },

        isPreviewConditionMet(question) {
            if (question.type === 'repeating_text' && question.repeating_ref) {
                const refQuestionId = this.findPreviewQuestionIdByRef(question.repeating_ref);
                if (refQuestionId) {
                    return Number(this.previewFormData[refQuestionId] || 0) > 0;
                }
            }

            const cqid = question.condition_question_id;
            const op = question.condition_operator;
            if (!cqid || !op) return true;

            const actual = this.previewFormData[cqid];
            const val = question.condition_value;

            switch (op) {
                case 'equals': return actual === val;
                case 'in': {
                    if (actual === undefined || actual === null || actual === '') return false;

                    let list = [];
                    try {
                        const parsed = JSON.parse(val);
                        if (Array.isArray(parsed)) {
                            list = parsed;
                        }
                    } catch (_) {
                        list = String(val || '').split(',').map(v => v.trim()).filter(v => v !== '');
                    }

                    return list.includes(actual);
                }
                case 'notEquals': return actual !== undefined && actual !== '' && actual !== val;
                case 'notEqualsStrict': return actual !== val;
                case 'includes': {
                    if (Array.isArray(actual)) {
                        return val !== undefined && actual.includes(val);
                    }

                    if (actual === undefined || actual === null || actual === '') {
                        return false;
                    }

                    return String(actual).toLowerCase().includes(String(val ?? '').toLowerCase());
                }
                case 'notEmpty': return actual !== undefined && actual !== '' && actual !== null;
                case 'greaterThan': return Number(actual) > Number(val);
                default: return true;
            }
        },

        editCategory(category) {
            this.editingCategoryId = category.id;
            this.categoryForm = { title: category.title, description: category.description };
            this.isEditingCategory = true;
        },

        async saveCategory() {
            if (!this.categoryForm.title.trim()) { alert('Please enter a category title'); return; }

            if (this.editingCategoryId) {
                const res = await fetch('/admin/api/categories/' + this.editingCategoryId, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify(this.categoryForm),
                });
                if (res.ok) {
                    const cat = this.categories.find(c => c.id === this.editingCategoryId);
                    if (cat) { cat.title = this.categoryForm.title; cat.description = this.categoryForm.description; }
                    if (this.selectedCategory?.id === this.editingCategoryId) {
                        this.selectedCategory.title = this.categoryForm.title;
                        this.selectedCategory.description = this.categoryForm.description;
                    }
                }
            } else {
                const res = await fetch('/admin/api/categories', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify(this.categoryForm),
                });
                if (res.ok) {
                    const newCat = await res.json();
                    this.categories.push(newCat);
                }
            }

            this.isEditingCategory = false;
            this.editingCategoryId = null;
            this.categoryForm = { title: '', description: '' };
        },

        async deleteCategory(id) {
            if (!confirm('Are you sure you want to delete this category? All questions will be removed.')) return;

            const res = await fetch('/admin/api/categories/' + id, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken },
            });

            if (res.ok) {
                this.categories = this.categories.filter(c => c.id !== id);
                if (this.selectedCategory?.id === id) this.selectedCategory = null;
            }
        },

        addAnswerOption() {
            this.questionForm.answers.push({ text: '', order: this.questionForm.answers.length + 1 });
        },

        editQuestion(question) {
            this.editingQuestionId = question.id;
            this.questionForm = {
                text: question.text,
                type: question.type,
                required: question.required,
                answers: (question.answers || []).map(a => ({ ...a })),
                placeholder: question.placeholder || 'Region XI',
                help_text: question.help_text || '',
                condition_question_id: question.condition_question_id || '',
                condition_operator: question.condition_operator || 'notEmpty',
                condition_value: question.condition_value || '',
            };
            this.isEditingQuestion = true;
        },

        async saveQuestion() {
            if (!this.questionForm.text.trim()) { alert('Please enter question text'); return; }
            if (!this.selectedCategory) return;

            const existingQuestion = this.editingQuestionId
                ? this.selectedCategory.questions.find(q => q.id === this.editingQuestionId)
                : null;

            const payload = {
                category_id: this.selectedCategory.id,
                text: this.questionForm.text,
                type: this.questionForm.type,
                required: this.questionForm.required,
                placeholder: this.questionForm.placeholder,
                help_text: this.questionForm.help_text,
                condition_question_id: this.questionForm.condition_question_id || null,
                condition_operator: this.questionForm.condition_question_id ? this.questionForm.condition_operator : null,
                condition_value: this.questionForm.condition_question_id ? this.questionForm.condition_value : null,
                order: existingQuestion?.order ?? this.selectedCategory.questions.length + 1,
                answers: this.questionForm.answers.map((a, i) => ({ text: a.text, order: i + 1 })),
            };

            if (this.editingQuestionId) {
                const res = await fetch('/admin/api/questions/' + this.editingQuestionId, {
                    method: 'PUT',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify(payload),
                });
                if (res.ok) {
                    const updated = await res.json();
                    const idx = this.selectedCategory.questions.findIndex(q => q.id === this.editingQuestionId);
                    if (idx !== -1) this.selectedCategory.questions[idx] = updated;
                    // Also update in categories array
                    const cat = this.categories.find(c => c.id === this.selectedCategory.id);
                    if (cat) {
                        const qi = cat.questions.findIndex(q => q.id === this.editingQuestionId);
                        if (qi !== -1) cat.questions[qi] = updated;
                    }
                }
            } else {
                const res = await fetch('/admin/api/questions', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify(payload),
                });
                if (res.ok) {
                    const newQ = await res.json();
                    this.selectedCategory.questions.push(newQ);
                    const cat = this.categories.find(c => c.id === this.selectedCategory.id);
                    if (cat && !cat.questions.find(q => q.id === newQ.id)) cat.questions.push(newQ);
                }
            }

            this.isEditingQuestion = false;
            this.editingQuestionId = null;
            this.questionForm = { text: '', type: 'text', required: false, answers: [], placeholder: 'Region XI', help_text: '', condition_question_id: '', condition_operator: 'notEmpty', condition_value: '' };
        },

        async deleteQuestion(id) {
            if (!confirm('Are you sure you want to delete this question?')) return;

            const res = await fetch('/admin/api/questions/' + id, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken },
            });

            if (res.ok) {
                this.selectedCategory.questions = this.selectedCategory.questions.filter(q => q.id !== id);
                const cat = this.categories.find(c => c.id === this.selectedCategory.id);
                if (cat) cat.questions = cat.questions.filter(q => q.id !== id);
            }
        },

        onQuestionDragStart(questionId) {
            this.draggedQuestionId = questionId;
        },

        async onQuestionDrop(targetQuestionId) {
            if (!this.selectedCategory || !this.draggedQuestionId || this.draggedQuestionId === targetQuestionId) {
                this.draggedQuestionId = null;
                return;
            }

            const sortedQuestions = this.selectedCategory.questions
                .slice()
                .sort((a, b) => a.order - b.order);

            const fromIndex = sortedQuestions.findIndex(q => q.id === this.draggedQuestionId);
            const toIndex = sortedQuestions.findIndex(q => q.id === targetQuestionId);

            if (fromIndex === -1 || toIndex === -1) {
                this.draggedQuestionId = null;
                return;
            }

            const [moved] = sortedQuestions.splice(fromIndex, 1);
            sortedQuestions.splice(toIndex, 0, moved);

            const normalized = sortedQuestions.map((q, idx) => ({ ...q, order: idx + 1 }));
            await this.persistQuestionOrder(normalized);
            this.draggedQuestionId = null;
        },

        async persistQuestionOrder(orderedQuestions) {
            const res = await fetch('/admin/api/questions/reorder', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({
                    category_id: this.selectedCategory.id,
                    question_orders: orderedQuestions.map(q => ({ id: q.id, order: q.order })),
                }),
            });

            if (res.ok) {
                const updatedQuestions = await res.json();
                this.selectedCategory.questions = updatedQuestions;
                const cat = this.categories.find(c => c.id === this.selectedCategory.id);
                if (cat) cat.questions = updatedQuestions;
            } else {
                alert('Unable to reorder questions. Please try again.');
            }
        },

    };
}
</script>

<style>
[x-cloak] { display: none !important; }
</style>
@endsection
