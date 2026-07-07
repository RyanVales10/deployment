@extends('layouts.app')

@section('title', 'ADDU Alumni Tracer Study')

@section('content')
<style>
    @import url('https://fonts.bunny.net/css?family=cinzel:400,700,800|nunito-sans:300,400,500,600,700,800');

    .survey-page {
        background: #f2f4f8;
        font-family: 'Nunito Sans', -apple-system, sans-serif;
    }

    /* ── Survey Navbar ── */
    .survey-navbar {
        background: #09107a;
        box-shadow: 0 2px 12px rgba(0,0,0,0.22);
        position: sticky;
        top: 0;
        z-index: 40;
    }

    .survey-scroll-bar {
        height: 4px;
        background: #fff;
    }

    .survey-navbar-inner {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0.6rem 1.5rem;
        display: grid;
        grid-template-columns: auto 1fr auto;
        align-items: center;
        gap: 1.5rem;
    }

    .survey-brand {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        min-width: 0;
    }

    .survey-brand-seal {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: contain;
        opacity: 0.92;
        flex-shrink: 0;
    }

    .survey-brand-title {
        display: block;
        font-family: 'Cinzel', serif;
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #fff;
        line-height: 1.3;
        white-space: nowrap;
    }

    .survey-brand-sub {
        display: block;
        font-family: 'Nunito Sans', sans-serif;
        font-size: 0.65rem;
        color: rgba(255,255,255,0.55);
        line-height: 1.3;
    }

    .survey-progress-wrap {
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }

    .survey-progress-track {
        flex: 1;
        height: 7px;
        background: rgba(255,255,255,0.18);
        border-radius: 999px;
        overflow: hidden;
    }

    .survey-progress-fill {
        height: 100%;
        background: #f5b800;
        border-radius: 999px;
        transition: width 0.35s ease;
    }

    .survey-progress-pct {
        font-family: 'Nunito Sans', sans-serif;
        font-size: 0.72rem;
        font-weight: 800;
        color: #f5b800;
        white-space: nowrap;
        min-width: 2.2rem;
        text-align: right;
    }

    .survey-nav-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.38rem 0.9rem;
        background: transparent;
        border: 1.5px solid rgba(255,255,255,0.45);
        border-radius: 8px;
        color: #fff;
        font-family: 'Nunito Sans', sans-serif;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s, border-color 0.15s;
        white-space: nowrap;
    }

    .survey-nav-btn:hover {
        background: rgba(255,255,255,0.12);
        border-color: rgba(255,255,255,0.7);
    }

    .survey-nav-btn svg { width: 13px; height: 13px; }

    .survey-nav-btn-home {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.38rem 0.9rem;
        background: #fff;
        border: 1.5px solid #fff;
        border-radius: 8px;
        color: #09107a;
        font-family: 'Nunito Sans', sans-serif;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        white-space: nowrap;
        transition: background 0.15s;
    }

    .survey-nav-btn-home svg { width: 13px; height: 13px; }
    .survey-nav-btn-home:hover { background: #eef2ff; }

    .survey-sheet {
        background: #f6f7fb;
        border: 1px solid #e3e8f2;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 6px 18px rgba(15, 42, 84, 0.06);
    }

    .section-hero {
        background: #ffffff;
        border: 1px solid #e1e7f0;
        border-radius: 14px;
        padding: 1.2rem 1rem;
        box-shadow: 0 8px 18px rgba(15, 42, 84, 0.08);
    }

    .section-chip {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(140deg, #0e4fb6 0%, #7d95c7 100%);
        color: #fff;
        font-weight: 700;
        box-shadow: 0 4px 14px rgba(14, 79, 182, 0.35);
    }

    .question-card {
        background: #ffffff;
        border: 1px solid #dde5f1;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 6px 14px rgba(15, 42, 84, 0.07);
    }

    .nav-footer {
        background: #f2f4f8;
        padding: 1.25rem 1.5rem;
    }

    .nav-footer-inner {
        max-width: 1280px;
        margin: 0 auto;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .nav-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0.65rem 1.4rem;
        border-radius: 10px;
        font-family: 'Nunito Sans', sans-serif;
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s;
        white-space: nowrap;
        text-decoration: none;
    }

    .nav-btn svg { width: 15px; height: 15px; flex-shrink: 0; }

    .nav-btn-prev {
        background: transparent;
        color: #6b7a99;
        border: 1.5px solid #d0daea;
    }

    .nav-btn-prev:hover { border-color: #09107a; color: #09107a; }
    .nav-btn-prev:disabled { opacity: 0.4; cursor: not-allowed; }

    .nav-btn-save {
        background: transparent;
        color: #09107a;
        border: 1.5px solid #c8d3ee;
    }

    .nav-btn-save:hover { background: #f0f4ff; border-color: #09107a; }
    .nav-btn-save:disabled { opacity: 0.5; cursor: not-allowed; }

    .nav-btn-next {
        background: #09107a;
        color: #fff;
        border: 1.5px solid #09107a;
    }

    .nav-btn-next:hover { background: #1a24d2; border-color: #1a24d2; }

    .nav-btn-submit {
        background: #09107a;
        color: #fff;
        border: 1.5px solid #09107a;
    }

    .nav-btn-submit:hover { background: #1a24d2; }
    .nav-btn-submit:disabled { opacity: 0.5; cursor: not-allowed; }

    /* ── Scrollable search dropdowns (country / PSGC location) ── */
    .psgc-dropdown,
    .country-dropdown {
        max-height: 16rem;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: #003087 #e5e7eb;
    }

    .psgc-dropdown::-webkit-scrollbar,
    .country-dropdown::-webkit-scrollbar { width: 8px; }
    .psgc-dropdown::-webkit-scrollbar-track,
    .country-dropdown::-webkit-scrollbar-track { background: #e5e7eb; border-radius: 8px; }
    .psgc-dropdown::-webkit-scrollbar-thumb,
    .country-dropdown::-webkit-scrollbar-thumb { background: #003087; border-radius: 8px; }
</style>
<div x-data="surveyApp()" x-cloak>
    {{-- ── Survey Form ── --}}
    <div class="min-h-screen survey-page pb-12">
            {{-- Header --}}
            <nav class="survey-navbar">
                <div class="survey-navbar-inner">

                    {{-- Brand --}}
                    <div class="survey-brand">
                        <img src="{{ asset('images/ADDU-SEAL-Colored.png') }}" alt="ADDU" class="survey-brand-seal" onerror="this.style.display='none'">
                        <span>
                            <span class="survey-brand-title">Ateneo Graduate Tracer Study</span>
                            <span class="survey-brand-sub" x-text="'Section ' + currentSection + ' of ' + totalSections"></span>
                        </span>
                    </div>

                    {{-- Progress bar --}}
                    <div class="survey-progress-wrap">
                        <div class="survey-progress-track">
                            <div class="survey-progress-fill" :style="{ width: Math.round(currentSection / totalSections * 100) + '%' }"></div>
                        </div>
                        <span class="survey-progress-pct" x-text="Math.round(currentSection / totalSections * 100) + '%'"></span>
                    </div>

                    {{-- Buttons --}}
                    <div style="display:flex;align-items:center;gap:0.5rem;">
                        <template x-if="!isEditMode">
                            <button class="survey-nav-btn" @click="showResumeDialog = true">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Resume
                            </button>
                        </template>
                        <a href="/" class="survey-nav-btn-home">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Home
                        </a>
                    </div>

                </div>
            </nav>
            <div class="survey-scroll-bar"></div>

            {{-- Resume Dialog --}}
            <template x-if="showResumeDialog">
                <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Resume Survey</h3>
                            <button @click="showResumeDialog = false; resumeError = ''" class="p-1 hover:bg-gray-100 rounded">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Enter your 6-character resume code to continue where you left off.</p>
                        <input
                            type="text"
                            maxlength="6"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg text-center text-2xl tracking-[0.3em] font-mono uppercase"
                            placeholder="ABC123"
                            x-model="resumeInput"
                            @keydown.enter="resumeSurvey()"
                        >
                        <template x-if="resumeError">
                            <p class="text-sm text-red-600 mt-2" x-text="resumeError"></p>
                        </template>
                        <button
                            @click="resumeSurvey()"
                            class="w-full mt-4 px-6 py-3 bg-[#003087] text-white rounded-lg font-medium hover:bg-[#002366] transition-colors"
                        >
                            Load My Progress
                        </button>
                    </div>
                </div>
            </template>

            {{-- Admin Login Modal --}}
            <template x-if="showLogin">
                <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full">
                        <div class="px-8 py-8">
                            <div class="flex items-center justify-between mb-6">
                                <div>
                                    <h3 class="text-xl font-semibold text-[#003087]">Admin Login</h3>
                                    <p class="text-sm text-gray-500 mt-1">Sign in to access the admin dashboard.</p>
                                </div>
                                <button @click="showLogin = false" class="p-1 hover:bg-gray-100 rounded-lg">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>

                            @if ($errors->any())
                            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700">
                                <ul class="space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                                @csrf
                                <div>
                                    <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input
                                        id="admin_email"
                                        name="email"
                                        type="email"
                                        value="{{ old('email') }}"
                                        required
                                        autofocus
                                        class="w-full rounded-xl border border-[#e3e3e0] bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-[#003087] focus:ring-2 focus:ring-[#003087]/20"
                                    >
                                </div>
                                <div>
                                    <label for="admin_password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                    <input
                                        id="admin_password"
                                        name="password"
                                        type="password"
                                        required
                                        class="w-full rounded-xl border border-[#e3e3e0] bg-white px-4 py-3 text-sm text-gray-900 outline-none transition focus:border-[#003087] focus:ring-2 focus:ring-[#003087]/20"
                                    >
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <input type="checkbox" id="admin_remember" name="remember" class="h-4 w-4 rounded border-gray-300 text-[#003087] focus:ring-[#003087]">
                                    <label for="admin_remember">Remember me</label>
                                </div>
                                <button type="submit" class="w-full rounded-xl bg-[#003087] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#002366]">
                                    Sign in
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Saved Banner --}}
            <template x-if="showSavedBanner && resumeCode">
                <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
                    <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6 text-center">
                        <p class="text-lg font-semibold text-gray-900 mb-1">Progress Saved!</p>
                        <p class="text-sm text-gray-600 mb-4">Your resume code:</p>
                        <div class="flex items-center justify-center gap-2 mb-2">
                            <span class="text-3xl font-mono font-bold tracking-[0.3em] text-[#003087]" x-text="resumeCode"></span>
                            <button @click="copyCode()" class="p-1.5 hover:bg-gray-100 rounded" title="Copy code">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                            </button>
                        </div>
                        <p class="text-xs text-gray-500 mb-2">Save this code to resume your progress anytime.</p>
                        <p class="text-xs text-red-500 font-medium mb-6">⚠ You have 10 days to complete the survey. After that, your saved progress will be deleted and you will need to start over.</p>
                        <button @click="showSavedBanner = false" class="w-full px-6 py-3 bg-[#003087] text-white rounded-lg font-medium hover:bg-[#002366] transition-colors">
                            Got it
                        </button>
                    </div>
                </div>
            </template>

            {{-- Main Content --}}
            <div class="max-w-4xl mx-auto px-6 py-8">
                <div class="survey-sheet">
                    <template x-if="currentCategory">
                        <div class="space-y-8">
                            {{-- Edit mode banner --}}
                            <template x-if="isEditMode && currentSection === 1">
                                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                    <p class="text-sm text-blue-800">
                                        <strong>Editing mode:</strong> You have already submitted this survey. You can review and update your answers below.
                                    </p>
                                </div>
                            </template>

                            {{-- Section Header --}}
                            <div class="section-hero">
                                <div class="flex items-start gap-3">
                                    <span class="section-chip" x-text="currentSection"></span>
                                    <div>
                                        <h2 class="mb-2 text-3xl font-extrabold text-[#11243f]" x-text="'SECTION ' + currentSection + ': ' + currentCategory.title.toUpperCase()"></h2>
                                        <p class="text-[#586a84]" x-text="currentCategory.description"></p>
                                    </div>
                                </div>
                            </div>

                            {{-- Questions --}}
                            <template x-if="visibleQuestions.length === 0">
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <p class="text-sm text-muted-foreground">No questions in this section yet.</p>
                                </div>
                            </template>

                            <div class="space-y-6">
                                <template x-for="question in visibleQuestions" :key="question.id">
                                    <div class="question-card space-y-2">
                                        <label class="block text-base font-semibold text-[#11243f]">
                                            <span x-text="question.text"></span>
                                            <template x-if="question.required && question.type !== 'display'">
                                                <span class="text-red-600 ml-1">*</span>
                                            </template>
                                        </label>
                                        <template x-if="question.help_text">
                                            <p class="text-xs text-[#6b7b94]" x-text="question.help_text"></p>
                                        </template>

                                        {{-- Display-only text --}}
                                        <template x-if="question.type === 'display'">
                                            <div class="w-full px-4 py-3 border border-border rounded-lg bg-gray-50 text-gray-800" x-text="question.placeholder || 'Region XI'"></div>
                                        </template>

                                        {{-- Pre-selected (single fixed answer, auto-filled, nothing to choose) --}}
                                        <template x-if="question.type === 'pre_selected'">
                                            <div class="flex items-center gap-2 px-4 py-3 border border-border rounded-lg bg-gray-50">
                                                <svg class="w-4 h-4 text-[#003087] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                <span class="text-sm text-gray-800" x-text="sortedAnswers(question)[0]?.text || question.placeholder || ''"></span>
                                            </div>
                                        </template>

                                        {{-- Text input --}}
                                        <template x-if="question.type === 'text'">
                                            <input
                                                type="text"
                                                class="w-full px-4 py-3 border border-border rounded-lg"
                                                :placeholder="question.placeholder || 'Your answer'"
                                                :value="formData[question.id] || ''"
                                                @input="formData[question.id] = $event.target.value"
                                            >
                                        </template>

                                        {{-- Textarea --}}
                                        <template x-if="question.type === 'textarea'">
                                            <textarea
                                                class="w-full px-4 py-3 border border-border rounded-lg min-h-[120px]"
                                                :placeholder="question.placeholder || 'Your answer'"
                                                :value="formData[question.id] || ''"
                                                @input="formData[question.id] = $event.target.value"
                                            ></textarea>
                                        </template>

                                        {{-- Number --}}
                                        <template x-if="question.type === 'number'">
                                            <input
                                                type="number"
                                                class="w-full md:w-1/3 px-4 py-3 border border-border rounded-lg"
                                                :placeholder="question.placeholder || '0'"
                                                :value="formData[question.id] || ''"
                                                :readonly="isAutoCalculatedAgeQuestion(question)"
                                                :class="isAutoCalculatedAgeQuestion(question) ? 'bg-gray-50 text-gray-600 cursor-not-allowed' : ''"
                                                @input="formData[question.id] = $event.target.value"
                                            >
                                        </template>

                                        {{-- Date --}}
                                        <template x-if="question.type === 'date'">
                                            <input
                                                type="date"
                                                class="w-full md:w-1/2 px-4 py-3 border border-border rounded-lg"
                                                :value="formData[question.id] || ''"
                                                @input="onDateChange(question, $event.target.value)"
                                                @change="onDateChange(question, $event.target.value)"
                                            >
                                        </template>

                                        {{-- Month --}}
                                        <template x-if="question.type === 'month'">
                                            <input
                                                type="month"
                                                class="w-full md:w-1/2 px-4 py-3 border border-border rounded-lg"
                                                :value="formData[question.id] || ''"
                                                @input="formData[question.id] = $event.target.value"
                                            >
                                        </template>

                                        {{-- Radio --}}
                                        <template x-if="question.type === 'radio'">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-1">
                                                <template x-for="answer in sortedAnswers(question)" :key="answer.id">
                                                    <label class="flex items-center gap-2 cursor-pointer">
                                                        <input
                                                            type="radio"
                                                            :name="'radio-' + question.id"
                                                            class="w-4 h-4 text-[#003087]"
                                                            :checked="formData[question.id] === answer.text || (answerNeedsSpecify(answer.text) && (formData[question.id] || '').startsWith(answer.text + ': '))"
                                                            @change="onRadioChange(question, answer.text)"
                                                        >
                                                        <span class="text-sm" x-text="answer.text"></span>
                                                    </label>
                                                </template>
                                                {{-- Specify text box for Others/Self-describe --}}
                                                <template x-if="getRadioSpecifyLabel(question) && ((formData[question.id] || '') === getRadioSpecifyLabel(question) || (formData[question.id] || '').startsWith(getRadioSpecifyLabel(question) + ': '))">
                                                    <div class="col-span-full mt-1">
                                                        <input
                                                            type="text"
                                                            class="w-full md:w-1/2 px-4 py-2 border border-border rounded-lg text-sm"
                                                            placeholder="Please specify..."
                                                            :value="(formData[question.id] || '').includes(': ') ? formData[question.id].substring(formData[question.id].indexOf(': ') + 2) : ''"
                                                            @input="formData[question.id] = getRadioSpecifyLabel(question) + ': ' + $event.target.value"
                                                        >
                                                    </div>
                                                </template>
                                            </div>
                                        </template>

                                        {{-- Checkbox --}}
                                        <template x-if="question.type === 'checkbox'">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-1">
                                                <template x-for="answer in sortedAnswers(question)" :key="answer.id">
                                                    <label class="flex items-center gap-2 cursor-pointer">
                                                        <input
                                                            type="checkbox"
                                                            class="w-4 h-4 text-[#003087] rounded"
                                                            :checked="(formData[question.id] || []).some(v => v === answer.text || (answer.text.toLowerCase().includes('other') && v.startsWith(answer.text + ': ')))"
                                                            @change="toggleCheckbox(question.id, answer.text, $event.target.checked)"
                                                        >
                                                        <span class="text-sm" x-text="answer.text"></span>
                                                    </label>
                                                </template>
                                                {{-- Others specify text box --}}
                                                <template x-if="sortedAnswers(question).some(a => a.text.toLowerCase().includes('other')) && (formData[question.id] || []).some(v => v.toLowerCase().startsWith('others'))">
                                                    <div class="col-span-full mt-1">
                                                        <input
                                                            type="text"
                                                            class="w-full md:w-1/2 px-4 py-2 border border-border rounded-lg text-sm"
                                                            placeholder="Please specify..."
                                                            :value="getOthersSpecifyValue(question.id)"
                                                            @input="setOthersSpecifyValue(question.id, $event.target.value)"
                                                        >
                                                    </div>
                                                </template>
                                            </div>
                                        </template>

                                        {{-- Select --}}
                                        <template x-if="question.type === 'select'">
                                            <div class="space-y-2">
                                                <select
                                                    class="w-full px-4 py-3 border border-border rounded-lg"
                                                    :value="formData[question.id] || ''"
                                                    @change="onSelectChange(question, $event.target.value)"
                                                >
                                                    <option value="">Select an option...</option>
                                                    <template x-for="answer in sortedAnswers(question)" :key="answer.id">
                                                        <option :value="answer.text" x-text="answer.text" :selected="formData[question.id] === answer.text || (answerNeedsSpecify(answer.text) && (formData[question.id] || '').startsWith(answer.text + ': '))"></option>
                                                    </template>
                                                </select>

                                                <template x-if="getSelectSpecifyLabel(question) && ((formData[question.id] || '') === getSelectSpecifyLabel(question) || (formData[question.id] || '').startsWith(getSelectSpecifyLabel(question) + ': '))">
                                                    <input
                                                        type="text"
                                                        class="w-full md:w-1/2 px-4 py-2 border border-border rounded-lg text-sm"
                                                        placeholder="Please specify..."
                                                        :value="(formData[question.id] || '').includes(': ') ? formData[question.id].substring(formData[question.id].indexOf(': ') + 2) : ''"
                                                        @input="formData[question.id] = getSelectSpecifyLabel(question) + ': ' + $event.target.value"
                                                    >
                                                </template>
                                            </div>
                                        </template>

                                        {{-- Country Select (umpirsky/country-list) --}}
                                        <template x-if="question.type === 'country_select'">
                                            <div x-data="{
                                                search: '',
                                                open: false,
                                                get filtered() {
                                                    if (!this.search) return countries;
                                                    return countries.filter(c => c.toLowerCase().includes(this.search.toLowerCase()));
                                                },
                                                select(country) {
                                                    formData[question.id] = country;
                                                    this.search = '';
                                                    this.open = false;
                                                }
                                            }" class="relative">
                                                <div class="relative">
                                                    <input
                                                        type="text"
                                                        class="w-full px-4 py-3 border border-border rounded-lg pr-9"
                                                        :class="formData[question.id] && !open ? 'font-medium text-[#003087]' : ''"
                                                        placeholder="Search for a country..."
                                                        :value="open ? search : (formData[question.id] || '')"
                                                        @input="search = $event.target.value"
                                                        @focus="open = true; search = ''"
                                                        @blur="setTimeout(() => open = false, 150)"
                                                    >
                                                    <button
                                                        type="button"
                                                        x-show="formData[question.id] && !open"
                                                        @mousedown.prevent="formData[question.id] = null; search = ''"
                                                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-red-500"
                                                    >✕</button>
                                                </div>
                                                <div
                                                    x-show="open && filtered.length > 0"
                                                    class="country-dropdown absolute z-20 w-full bg-white border border-border rounded-lg shadow-lg mt-1"
                                                >
                                                    <template x-for="country in filtered" :key="country">
                                                        <div
                                                            @mousedown.prevent="select(country)"
                                                            class="px-4 py-2 text-sm cursor-pointer hover:bg-blue-50"
                                                            :class="formData[question.id] === country ? 'bg-blue-50 font-medium text-[#003087]' : 'text-gray-800'"
                                                            x-text="country"
                                                        ></div>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>

                                        {{-- PSGC Location Dropdowns (Region / Province / Municipality / Barangay) --}}
                                        <template x-if="['region_select','province_select','municipality_select','barangay_select'].includes(question.type)">
                                            <div class="relative">
                                                <div class="relative">
                                                    <input
                                                        type="text"
                                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg pr-9 focus:border-[#003087] focus:outline-none transition"
                                                        :class="formData[question.id] && !psgcOpen[question.id] ? 'font-medium text-[#003087]' : ''"
                                                        :placeholder="
                                                            question.type === 'province_select'     && psgc.provinces.length === 0     ? 'Select a region first...' :
                                                            question.type === 'municipality_select' && psgc.municipalities.length === 0 ? 'Select a province first...' :
                                                            question.type === 'barangay_select'     && psgc.barangays.length === 0      ? 'Select a municipality first...' :
                                                            'Search...'"
                                                        :disabled="
                                                            (question.type === 'province_select'     && psgc.provinces.length === 0) ||
                                                            (question.type === 'municipality_select' && psgc.municipalities.length === 0) ||
                                                            (question.type === 'barangay_select'     && psgc.barangays.length === 0)"
                                                        :value="psgcOpen[question.id] ? (psgcSearch[question.id] || '') : (formData[question.id] || psgcSearch[question.id] || '')"
                                                        @input="psgcSearch[question.id] = $event.target.value"
                                                        @focus="psgcOpen[question.id] = true; psgcSearch[question.id] = ''"
                                                        @blur="setTimeout(() => { psgcOpen[question.id] = false }, 150)"
                                                    >
                                                    <button
                                                        type="button"
                                                        x-show="formData[question.id] && !psgcOpen[question.id]"
                                                        @mousedown.prevent="delete formData[question.id]; psgcSearch[question.id] = ''; clearPsgcDownstream(question.type)"
                                                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-red-500"
                                                    >✕</button>
                                                </div>
                                                <div
                                                    x-show="psgcOpen[question.id] && getPsgcFiltered(question.id, question.type).length > 0"
                                                    class="psgc-dropdown absolute z-40 w-full bg-white border-2 border-[#003087] rounded-lg shadow-2xl mt-2"
                                                >
                                                    <template x-for="item in getPsgcFiltered(question.id, question.type)" :key="getPsgcCode(item)">
                                                        <div
                                                            @mousedown.prevent="selectPsgcItem(question, item)"
                                                            class="px-4 py-3 text-sm cursor-pointer hover:bg-[#e7f0ff] border-b border-gray-100 transition"
                                                            :class="formData[question.id] === getPsgcName(item) ? 'bg-[#e7f0ff] font-medium text-[#003087]' : 'text-gray-800'"
                                                            x-text="getPsgcName(item)"
                                                        ></div>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>

                                        {{-- Repeating Text (dynamic based on number from another question) --}}
                                        <template x-if="question.type === 'repeating_text'">
                                            <div class="space-y-3">
                                                <template x-for="(idx) in getRepeatingCount(question)" :key="'repeat-' + question.id + '-' + idx">
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600 mb-1" x-text="'Item ' + idx + ' of ' + getRepeatingCount(question)"></label>
                                                        <input
                                                            type="text"
                                                            class="w-full px-4 py-3 border border-border rounded-lg"
                                                            :placeholder="question.placeholder || 'Enter details'"
                                                            :value="(formData[question.id] || [])[idx - 1] || ''"
                                                            @input="setRepeatingItem(question.id, idx - 1, $event.target.value)"
                                                        >
                                                    </div>
                                                </template>
                                            </div>
                                        </template>

                                        {{-- Repeating Dropdown (dynamic based on number from another question) --}}
                                        <template x-if="question.type === 'repeating_select'">
                                            <div class="space-y-3">
                                                <template x-for="(idx) in getRepeatingCount(question)" :key="'repeat-' + question.id + '-' + idx">
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-600 mb-1" x-text="'Item ' + idx + ' of ' + getRepeatingCount(question)"></label>
                                                        <select
                                                            class="w-full px-4 py-3 border border-border rounded-lg"
                                                            :value="(formData[question.id] || [])[idx - 1] || ''"
                                                            @change="setRepeatingItem(question.id, idx - 1, $event.target.value)"
                                                        >
                                                            <option value="">Select an option...</option>
                                                            <template x-for="answer in sortedAnswers(question)" :key="answer.id">
                                                                <option :value="answer.text" x-text="answer.text" :selected="(formData[question.id] || [])[idx - 1] === answer.text"></option>
                                                            </template>
                                                        </select>
                                                    </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>

                        </div>
                    </template>
                </div>
            </div>

            {{-- Navigation Footer --}}
            <div class="nav-footer">
                <div class="nav-footer-inner">
                    <button
                        class="nav-btn nav-btn-prev"
                        @click="previousSection()"
                        :disabled="currentSection === 1"
                    >
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        Previous Section
                    </button>

                    <template x-if="!isEditMode">
                        <button
                            class="nav-btn nav-btn-save"
                            @click="saveForLater()"
                            :disabled="saving"
                        >
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span x-text="saving ? 'Saving...' : 'Save for Later'"></span>
                        </button>
                    </template>

                    <template x-if="currentSection < totalSections">
                        <button class="nav-btn nav-btn-next" @click="nextSection()">
                            Next Section
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </template>

                    <template x-if="currentSection >= totalSections">
                        <button class="nav-btn nav-btn-submit" @click="submitSurvey()" :disabled="saving">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="saving ? 'Saving...' : (isEditMode ? 'Update Answers' : 'Submit Survey')"></span>
                        </button>
                    </template>
                </div>
            </div>
        </div>

    {{-- Submission Success Modal --}}
    <div
        x-show="showSuccessModal"
        x-cloak
        style="position:fixed;inset:0;z-index:999;display:flex;align-items:center;justify-content:center;padding:1.5rem;background:rgba(9,16,122,0.55);backdrop-filter:blur(4px);"
    >
        <div style="background:#fff;border-radius:18px;max-width:500px;width:100%;box-shadow:0 32px 64px rgba(9,16,122,0.28);overflow:hidden;">
            {{-- Modal top bar --}}
            <div style="background:linear-gradient(135deg,#09107a 0%,#1a24d2 100%);padding:1.75rem 2rem 1.5rem;">
                <div style="width:48px;height:48px;background:rgba(255,255,255,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                    <svg width="24" height="24" fill="none" stroke="#f5b800" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <h2 style="font-family:'Cinzel',serif;font-size:1.2rem;font-weight:700;color:#fff;letter-spacing:0.03em;margin:0 0 0.3rem;">Survey Submitted!</h2>
                <p style="font-family:'Nunito Sans',sans-serif;font-size:0.82rem;color:rgba(255,255,255,0.65);margin:0;">Ateneo Graduate Tracer Study</p>
            </div>
            {{-- Modal body --}}
            <div style="padding:1.75rem 2rem;">
                <p style="font-family:'Nunito Sans',sans-serif;font-size:0.95rem;color:#10233f;line-height:1.7;margin:0 0 1rem;">
                    Thank you for completing the <strong>Graduate Tracer Survey!</strong> Your valuable responses will help us improve our academic programs and services.
                </p>
                <div style="background:#f0f4ff;border-left:3px solid #c9a227;border-radius:0 8px 8px 0;padding:0.85rem 1rem;margin-bottom:1.5rem;">
                    <p style="font-family:'Nunito Sans',sans-serif;font-size:0.88rem;color:#2a3a6b;line-height:1.65;margin:0;">
                        As a token of appreciation for your time and effort, you are entitled to participate in the <strong>raffle</strong> for a chance to win an <strong>official AdDU polo shirt!</strong>
                    </p>
                </div>
                <a href="/" style="display:flex;align-items:center;justify-content:center;gap:0.5rem;width:100%;padding:0.75rem 1rem;background:#09107a;color:#fff;border-radius:9px;font-family:'Nunito Sans',sans-serif;font-size:0.9rem;font-weight:700;text-decoration:none;transition:background 0.15s;" onmouseover="this.style.background='#1a24d2'" onmouseout="this.style.background='#09107a'">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function surveyApp() {
    const categories = @json($categories);

    return {
        categories: categories.sort((a, b) => a.order - b.order),
        currentSection: 1,
        formData: {},
        respondentEmail: null,
        isEditMode: false,
        existingResponseId: null,
        resumeCode: null,
        showResumeDialog: false,
        resumeInput: '',
        resumeError: '',
        saving: false,
        showSavedBanner: false,
        showSuccessModal: false,
        showLogin: {{ ($errors->has('email') || $errors->has('password') || session('show_login_modal')) ? 'true' : 'false' }},
        countries: [],
        psgc: {
            regions: [],
            provinces: [],
            municipalities: [],
            barangays: [],
            regionCode: null,
            provinceCode: null,
            municipalityCode: null,
        },
        psgcSearch: {},
        psgcOpen: {},

        parsePsgcCollection(payload) {
            if (payload && Array.isArray(payload.data)) {
                return payload.data;
            }

            return Array.isArray(payload) ? payload : [];
        },

        init() {
            this.syncAutoCalculatedAge();
            this.applyPreSelectedDefaults();
            // Prevent users from using the Back button to return to the welcome page
            try {
                history.pushState(null, '', location.href);
                window.addEventListener('popstate', () => {
                    history.pushState(null, '', location.href);
                });
            } catch (e) {
                // ignore
            }
            fetch('/api/countries')
                .then(r => {
                    if (!r.ok) {
                        throw new Error('Countries endpoint failed with status ' + r.status);
                    }
                    return r.json();
                })
                .then(data => {
                    this.countries = Array.isArray(data.countries) ? data.countries : [];
                })
                .catch(err => {
                    console.error('Countries fetch failed:', err);
                });
            fetch('/api/psgc/regions')
                .then(r => r.json())
                .then(data => {
                    this.psgc.regions = this.parsePsgcCollection(data);
                })
                .catch(err => {
                    console.error('Regions fetch failed:', err);
                });
        },

        get totalSections() {
            return this.categories.length;
        },

        get currentCategory() {
            return this.categories[this.currentSection - 1] || null;
        },

        get visibleQuestions() {
            if (!this.currentCategory) return [];
            return this.currentCategory.questions
                .slice()
                .sort((a, b) => a.order - b.order)
                .filter(q => this.isConditionMet(q));
        },

        sortedAnswers(question) {
            return (question.answers || []).slice().sort((a, b) => a.order - b.order);
        },

        applyPreSelectedDefaults() {
            this.categories.forEach(category => {
                (category.questions || []).forEach(question => {
                    if (question.type !== 'pre_selected' || this.formData[question.id]) return;

                    const answer = this.sortedAnswers(question)[0];
                    if (answer) {
                        this.formData[question.id] = answer.text;
                    }
                });
            });
        },

        onRadioChange(question, value) {
            this.formData[question.id] = value;

            if (question.text === 'Is your current address in the Philippines or abroad?') {
                this.normalizeAddressFields(value);
            }
        },

        onSelectChange(question, value) {
            this.formData[question.id] = value;
        },

        onDateChange(question, value) {
            this.formData[question.id] = value;
            if (this.isBirthdayQuestion(question)) {
                this.syncAutoCalculatedAge();
            }
        },

        isBirthdayQuestion(question) {
            return this.getCategoryOrderForQuestion(question.id) === 2 && (question.text === 'Birthday' || question.text === 'Month of birth');
        },

        isAutoCalculatedAgeQuestion(question) {
            return this.getCategoryOrderForQuestion(question.id) === 2 && question.text === 'Age on last birthday';
        },

        getCategoryOrderForQuestion(questionId) {
            const category = this.categories.find(c => (c.questions || []).some(q => q.id === questionId));
            return category ? category.order : null;
        },

        findQuestionIdByCategoryAndText(categoryOrder, text) {
            const category = this.categories.find(c => c.order === categoryOrder);
            if (!category) return null;

            const question = (category.questions || []).find(q => q.text === text);
            return question ? question.id : null;
        },

        calculateAgeFromBirthday(birthdayValue) {
            if (!birthdayValue) return '';

            const birthday = new Date(birthdayValue + 'T00:00:00');
            if (Number.isNaN(birthday.getTime())) return '';

            const today = new Date();
            let age = today.getFullYear() - birthday.getFullYear();
            const hasHadBirthdayThisYear =
                today.getMonth() > birthday.getMonth() ||
                (today.getMonth() === birthday.getMonth() && today.getDate() >= birthday.getDate());

            if (!hasHadBirthdayThisYear) {
                age -= 1;
            }

            return age >= 0 ? String(age) : '';
        },

        syncAutoCalculatedAge() {
            const birthdayQuestionId = this.findQuestionIdByCategoryAndText(2, 'Birthday') || this.findQuestionIdByCategoryAndText(2, 'Month of birth');
            const ageQuestionId = this.findQuestionIdByCategoryAndText(2, 'Age on last birthday');

            if (!birthdayQuestionId || !ageQuestionId) return;

            this.formData[ageQuestionId] = this.calculateAgeFromBirthday(this.formData[birthdayQuestionId]);
        },

        normalizeAddressFields(locationValue) {
            const localFieldLabels = [
                'Urban/Rural',
                'Address',
                'Barangay',
                'Municipality',
                'Province',
                'Region',
                'Zip Code',
                'Geocode',
            ];

            if (locationValue === 'Abroad') {
                localFieldLabels.forEach(label => {
                    const questionId = this.findIdentificationQuestionIdByText(label);
                    if (questionId) {
                        delete this.formData[questionId];
                    }
                });
            }

            if (locationValue === 'Philippines') {
                const countryQuestionId = this.findIdentificationQuestionIdByText('Which country are you currently in?');
                if (countryQuestionId) {
                    delete this.formData[countryQuestionId];
                }
            }
        },

        findIdentificationQuestionIdByText(text) {
            const identificationCategory = this.categories.find(c => c.order === 1);
            if (!identificationCategory) return null;

            const question = (identificationCategory.questions || []).find(q => q.text === text);
            return question ? question.id : null;
        },

        getPsgcName(item) {
            if (item.regionName && item.name) return item.regionName + ' - ' + item.name;
            return item.name || '';
        },

        getPsgcCode(item) {
            return item.code || '';
        },

        getPsgcItems(type) {
            if (type === 'region_select')       return this.psgc.regions;
            if (type === 'province_select')     return this.psgc.provinces;
            if (type === 'municipality_select') return this.psgc.municipalities;
            if (type === 'barangay_select')     return this.psgc.barangays;
            return [];
        },

        getPsgcFiltered(questionId, type) {
            const s = (this.psgcSearch[questionId] || '').toLowerCase();
            const items = this.getPsgcItems(type);
            const filtered = s ? items.filter(i => this.getPsgcName(i).toLowerCase().includes(s)) : items;
            return filtered;
        },

        selectPsgcItem(question, item) {
            const name = this.getPsgcName(item);
            const code = this.getPsgcCode(item);
            this.formData[question.id] = name;
            this.psgcSearch[question.id] = '';
            this.psgcOpen[question.id] = false;

            if (question.type === 'region_select') {
                this.psgc.regionCode = code;
                this.psgc.provinces = [];
                this.psgc.municipalities = [];
                this.psgc.barangays = [];
                this.psgc.provinceCode = null;
                this.psgc.municipalityCode = null;
                this.clearPsgcDownstream('region_select');
                fetch('/api/psgc/regions/' + encodeURIComponent(code) + '/provinces')
                    .then(r => r.json())
                    .then(data => {
                        this.psgc.provinces = this.parsePsgcCollection(data)
                            .sort((a, b) => a.name.localeCompare(b.name));
                    })
                    .catch(err => {
                        console.error('Provinces fetch failed:', err);
                    });
            } else if (question.type === 'province_select') {
                this.psgc.provinceCode = code;
                this.psgc.municipalities = [];
                this.psgc.barangays = [];
                this.psgc.municipalityCode = null;
                this.clearPsgcDownstream('province_select');
                fetch('/api/psgc/provinces/' + encodeURIComponent(code) + '/cities-municipalities')
                    .then(r => r.json())
                    .then(data => {
                        this.psgc.municipalities = this.parsePsgcCollection(data)
                            .sort((a, b) => a.name.localeCompare(b.name));
                    })
                    .catch(err => {
                        console.error('Municipalities fetch failed:', err);
                    });
            } else if (question.type === 'municipality_select') {
                this.psgc.municipalityCode = code;
                this.psgc.barangays = [];
                this.clearPsgcDownstream('municipality_select');
                fetch('/api/psgc/cities-municipalities/' + encodeURIComponent(code) + '/barangays')
                    .then(r => r.json())
                    .then(data => {
                        this.psgc.barangays = this.parsePsgcCollection(data)
                            .sort((a, b) => a.name.localeCompare(b.name));
                    })
                    .catch(err => {
                        console.error('Barangays fetch failed:', err);
                    });
            }
        },

        clearPsgcDownstream(fromType) {
            const order = ['region_select', 'province_select', 'municipality_select', 'barangay_select'];
            const idx = order.indexOf(fromType);
            for (const cat of this.categories) {
                for (const q of (cat.questions || [])) {
                    if (order.indexOf(q.type) > idx) {
                        delete this.formData[q.id];
                    }
                }
            }
        },

        isConditionMet(question) {
            if (question.type === 'repeating_text' && question.repeating_ref) {
                const refQuestionId = this.findQuestionIdByRef(question.repeating_ref);
                if (refQuestionId) {
                    return Number(this.formData[refQuestionId] || 0) > 0;
                }
            }

            const cqid = question.condition_question_id;
            const op = question.condition_operator;
            if (!cqid || !op) return true;

            const actual = this.formData[cqid];
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
                    if (val === undefined || val === null) return false;
                    const needle = String(val).trim().toLowerCase();

                    if (Array.isArray(actual)) {
                        return actual.some(v => String(v ?? '').trim().toLowerCase() === needle);
                    }

                    if (actual === undefined || actual === null || actual === '') {
                        return false;
                    }

                    return String(actual).trim().toLowerCase().includes(needle);
                }
                case 'notEmpty': return actual !== undefined && actual !== '' && actual !== null;
                case 'greaterThan': return Number(actual) > Number(val);
                default: return true;
            }
        },

        toggleCheckbox(questionId, text, checked) {
            let current = this.formData[questionId] || [];
            if (checked) {
                this.formData[questionId] = [...current, text];
            } else {
                // Remove both exact match and "Others: ..." prefixed entries
                this.formData[questionId] = current.filter(v => v !== text && !(text.toLowerCase().includes('other') && v.startsWith(text + ': ')));
            }
        },

        answerNeedsSpecify(answerText) {
            const text = (answerText || '').toLowerCase();
            return text.includes('other') || text.includes('self-describe') || text.includes('self describe');
        },

        getRadioSpecifyLabel(question) {
            const specifyAnswer = this.sortedAnswers(question).find(a => this.answerNeedsSpecify(a.text));
            return specifyAnswer ? specifyAnswer.text : '';
        },

        getSelectSpecifyLabel(question) {
            const specifyAnswer = this.sortedAnswers(question).find(a => this.answerNeedsSpecify(a.text));
            return specifyAnswer ? specifyAnswer.text : '';
        },

        getOthersLabel(question) {
            const othersAnswer = this.sortedAnswers(question).find(a => a.text.toLowerCase().includes('other'));
            return othersAnswer ? othersAnswer.text : 'Others';
        },

        getOthersSpecifyValue(questionId) {
            const values = this.formData[questionId] || [];
            const othersEntry = values.find(v => v.toLowerCase().startsWith('others'));
            if (othersEntry && othersEntry.includes(': ')) {
                return othersEntry.substring(othersEntry.indexOf(': ') + 2);
            }
            return '';
        },

        setOthersSpecifyValue(questionId, value) {
            let current = this.formData[questionId] || [];
            const idx = current.findIndex(v => v.toLowerCase().startsWith('others'));
            if (idx !== -1) {
                const label = current[idx].includes(': ') ? current[idx].substring(0, current[idx].indexOf(': ')) : current[idx];
                current[idx] = value ? label + ': ' + value : label;
                this.formData[questionId] = [...current];
            }
        },

        getRepeatingCount(question) {
            let sourceQuestionId = question.repeat_count_question_id || null;

            if (!sourceQuestionId && question.repeating_ref) {
                sourceQuestionId = this.findQuestionIdByRef(question.repeating_ref);
            }

            // Backward-compatible fallback: use the condition question as the count source.
            // Only safe when the condition question is itself a number question, which is
            // no longer guaranteed now that visibility rules can point at other question types.
            if (!sourceQuestionId && question.condition_question_id) {
                sourceQuestionId = question.condition_question_id;
            }

            if (!sourceQuestionId) return 0;

            const sourceQuestion = this.categories
                .flatMap(cat => cat.questions || [])
                .find(q => q.id === sourceQuestionId);

            if (!sourceQuestion || sourceQuestion.type !== 'number') return 0;

            const count = Math.max(0, Math.min(100, parseInt(this.formData[sourceQuestionId] || 0)));
            return count;
        },

        findQuestionIdByRef(ref) {
            for (const cat of this.categories) {
                for (const q of cat.questions) {
                    if (q.ref === ref) return q.id;
                }
            }
            return null;
        },

        setRepeatingItem(questionId, index, value) {
            if (!this.formData[questionId]) {
                this.formData[questionId] = [];
            }
            if (!Array.isArray(this.formData[questionId])) {
                this.formData[questionId] = [];
            }
            this.formData[questionId][index] = value;
            this.formData[questionId] = [...this.formData[questionId]];
        },

        nextSection() {
            // Validate required questions in current section before proceeding
            const missing = [];
            for (const question of this.visibleQuestions) {
                if (!question.required || question.type === 'display') continue;

                const val = this.formData[question.id];
                let answered = false;

                if (question.type === 'checkbox') {
                    answered = Array.isArray(val) && val.length > 0;
                } else if (question.type === 'radio' || question.type === 'select') {
                    answered = val !== undefined && val !== null && String(val).trim() !== '';
                } else if (question.type === 'repeating_text' || question.type === 'repeating_select') {
                    const count = this.getRepeatingCount(question);
                    answered = Array.isArray(val) && val.length === count && val.every(v => (v !== null && String(v).trim() !== ''));
                } else {
                    answered = val !== undefined && val !== null && String(val).trim() !== '';
                }

                if (!answered) {
                    missing.push(question.text || 'Unnamed question');
                }
            }

            if (missing.length > 0) {
                alert('Please answer the required questions before continuing:\n\n' + missing.map(m => '- ' + m).join('\n'));
                return;
            }

            if (this.currentSection < this.totalSections) {
                this.currentSection++;
                window.scrollTo({ top: 0, behavior: 'instant' });
            }
        },

        previousSection() {
            if (this.currentSection > 1) {
                this.currentSection--;
                window.scrollTo({ top: 0, behavior: 'instant' });
            }
        },

        async saveForLater() {
            this.saving = true;
            try {
                const res = await fetch('/survey/save-draft', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ formData: this.formData, currentSection: this.currentSection }),
                });
                const data = await res.json();
                this.resumeCode = data.code;
                this.showSavedBanner = true;
            } catch {
                alert('An error occurred while saving. Please try again.');
            } finally {
                this.saving = false;
            }
        },

        async resumeSurvey() {
            const code = this.resumeInput.trim().toUpperCase();
            if (!code) { this.resumeError = 'Please enter a resume code.'; return; }

            try {
                const res = await fetch('/survey/resume', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({ code }),
                });

                if (!res.ok) {
                    const err = await res.json();
                    this.resumeError = err.error || 'Invalid resume code.';
                    return;
                }

                const data = await res.json();
                this.formData = data.formData;
                this.currentSection = data.currentSection;
                this.syncAutoCalculatedAge();
                this.applyPreSelectedDefaults();
                this.showResumeDialog = false;
                this.resumeInput = '';
                this.resumeError = '';
            } catch {
                this.resumeError = 'An error occurred. Please try again.';
            }
        },

        copyCode() {
            if (this.resumeCode) {
                navigator.clipboard.writeText(this.resumeCode);
                alert('Resume code copied to clipboard!');
            }
        },

        async submitSurvey() {
            this.saving = true;
            try {
                const res = await fetch('/survey/submit', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify({
                        email: this.respondentEmail,
                        formData: this.formData,
                        existingResponseId: this.existingResponseId,
                        resumeCode: this.resumeCode,
                    }),
                });

                if (res.ok) {
                    this.formData = {};
                    this.respondentEmail = null;
                    this.currentSection = 1;
                    this.isEditMode = false;
                    this.existingResponseId = null;
                    this.showSuccessModal = true;
                } else {
                    alert('Failed to submit. Please try again.');
                }
            } catch {
                alert('An error occurred. Please try again.');
            } finally {
                this.saving = false;
            }
        },
    };
}
</script>

<style>
[x-cloak] { display: none !important; }

.survey-progress-shell {
    position: relative;
    height: 12px;
    border-radius: 9999px;
    overflow: hidden;
    background: linear-gradient(90deg, #e9eef7 0%, #dde7f6 100%);
    box-shadow: inset 0 1px 2px rgba(15, 23, 42, 0.12);
}

.survey-progress-fill {
    position: relative;
    height: 100%;
    border-radius: inherit;
    transition: width 420ms cubic-bezier(0.22, 1, 0.36, 1);
    background: linear-gradient(90deg, #0f4ab7 0%, #003087 55%, #2457ba 100%);
    box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.15) inset, 0 2px 10px rgba(0, 48, 135, 0.35);
}

.survey-progress-fill::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, rgba(255, 255, 255, 0) 35%, rgba(255, 255, 255, 0.35) 50%, rgba(255, 255, 255, 0) 65%);
    transform: translateX(-120%);
    animation: survey-progress-shimmer 2.2s ease-in-out infinite;
}

@keyframes survey-progress-shimmer {
    0%, 35% { transform: translateX(-120%); }
    100% { transform: translateX(140%); }
}
</style>
@endsection
