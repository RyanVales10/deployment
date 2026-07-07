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
        background: linear-gradient(135deg, #09107a 0%, #1a24d2 100%);
        border-radius: 14px;
        padding: 1.75rem 2rem;
        box-shadow: 0 8px 24px rgba(9, 16, 122, 0.28);
        position: relative;
        overflow: hidden;
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
                            <div class="survey-progress-fill" :style="{ width: answeredProgress + '%' }"></div>
                        </div>
                        <span class="survey-progress-pct" x-text="answeredProgress + '%'"></span>
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
                                <div style="display:flex;align-items:center;justify-content:space-between;">
                                    <div>
                                        <p style="font-family:'Nunito Sans',sans-serif;font-size:0.85rem;font-weight:700;color:#f5b800;letter-spacing:0.14em;text-transform:uppercase;margin:0 0 0.45rem;display:flex;align-items:center;gap:0.5rem;">
                                            <span style="display:inline-block;width:16px;height:2px;background:#f5b800;border-radius:1px;flex-shrink:0;"></span>
                                            <span x-text="'Section ' + currentSection + ' of ' + totalSections"></span>
                                        </p>
                                        <h2 style="font-family:'Cinzel',serif;font-size:2rem;font-weight:700;color:#fff;letter-spacing:0.03em;margin:0 0 0.75rem;" x-text="currentCategory.title.toUpperCase()"></h2>
                                        <template x-if="currentCategory.description">
                                            <div style="background:rgba(255,255,255,0.1);border-radius:6px;padding:0.6rem 0.85rem;">
                                                <p style="font-family:'Nunito Sans',sans-serif;font-size:0.85rem;color:rgba(255,255,255,0.75);line-height:1.6;margin:0;" x-text="currentCategory.description"></p>
                                            </div>
                                        </template>
                                    </div>
                                    <div style="font-family:'Cinzel',serif;font-size:4.5rem;font-weight:800;color:rgba(255,255,255,0.1);line-height:1;padding-left:1.5rem;flex-shrink:0;" x-text="String(currentSection).padStart(2,'0')"></div>
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

                                        {{-- Country Select (from restcountries.com) --}}
                                        <template x-if="question.type === 'country_select'">
                                            <div x-data="{
                                                search: '',
                                                open: false,
                                                get filtered() {
                                                    if (!this.search) return countries.slice(0, 80);
                                                    return countries.filter(c => c.toLowerCase().includes(this.search.toLowerCase())).slice(0, 80);
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
                                                        class="w-full px-4 py-3 border border-border rounded-lg pr-10"
                                                        placeholder="Search for a country..."
                                                        x-model="search"
                                                        @focus="open = true"
                                                        @blur="setTimeout(() => open = false, 150)"
                                                    >
                                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                                        <template x-if="formData[question.id] && !open">
                                                            <span class="text-xs text-gray-500 max-w-[160px] truncate" x-text="formData[question.id]"></span>
                                                        </template>
                                                        <template x-if="!formData[question.id] || open">
                                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 111 11a6 6 0 0116 0z"/></svg>
                                                        </template>
                                                    </div>
                                                </div>
                                                <template x-if="formData[question.id] && !open">
                                                    <div class="mt-1 flex items-center gap-2">
                                                        <span class="text-sm font-medium text-[#003087]" x-text="formData[question.id]"></span>
                                                        <button type="button" @click="formData[question.id] = null; search = ''" class="text-xs text-gray-400 hover:text-red-500">✕</button>
                                                    </div>
                                                </template>
                                                <div
                                                    x-show="open && filtered.length > 0"
                                                    class="absolute z-20 w-full bg-white border border-border rounded-lg shadow-lg mt-1 max-h-56 overflow-y-auto"
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
                                                        class="w-full px-4 py-3 border border-border rounded-lg pr-10"
                                                        :placeholder="
                                                            question.type === 'province_select'     && psgc.provinces.length === 0     ? 'Select a region first...' :
                                                            question.type === 'municipality_select' && psgc.municipalities.length === 0 ? 'Select a province first...' :
                                                            question.type === 'barangay_select'     && psgc.barangays.length === 0      ? 'Select a municipality first...' :
                                                            'Search...'"
                                                        :disabled="
                                                            (question.type === 'province_select'     && psgc.provinces.length === 0) ||
                                                            (question.type === 'municipality_select' && psgc.municipalities.length === 0) ||
                                                            (question.type === 'barangay_select'     && psgc.barangays.length === 0)"
                                                        :value="psgcSearch[question.id] || ''"
                                                        @input="psgcSearch[question.id] = $event.target.value"
                                                        @focus="psgcOpen[question.id] = true"
                                                        @blur="setTimeout(() => { psgcOpen[question.id] = false }, 150)"
                                                    >
                                                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                                        <template x-if="formData[question.id] && !psgcOpen[question.id]">
                                                            <span class="text-xs text-gray-500 max-w-[160px] truncate" x-text="formData[question.id]"></span>
                                                        </template>
                                                        <template x-if="!formData[question.id] || psgcOpen[question.id]">
                                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 111 11a6 6 0 0116 0z"/></svg>
                                                        </template>
                                                    </div>
                                                </div>
                                                <template x-if="formData[question.id] && !psgcOpen[question.id]">
                                                    <div class="mt-1 flex items-center gap-2">
                                                        <span class="text-sm font-medium text-[#003087]" x-text="formData[question.id]"></span>
                                                        <button type="button" @click="delete formData[question.id]; psgcSearch[question.id] = ''; clearPsgcDownstream(question.type)" class="text-xs text-gray-400 hover:text-red-500">✕</button>
                                                    </div>
                                                </template>
                                                <div
                                                    x-show="psgcOpen[question.id] && getPsgcFiltered(question.id, question.type).length > 0"
                                                    class="absolute z-20 w-full bg-white border border-border rounded-lg shadow-lg mt-1 max-h-56 overflow-y-auto"
                                                >
                                                    <template x-for="item in getPsgcFiltered(question.id, question.type)" :key="getPsgcCode(item)">
                                                        <div
                                                            @mousedown.prevent="selectPsgcItem(question, item)"
                                                            class="px-4 py-2 text-sm cursor-pointer hover:bg-blue-50"
                                                            :class="formData[question.id] === getPsgcName(item) ? 'bg-blue-50 font-medium text-[#003087]' : 'text-gray-800'"
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

    {{-- Alert Modal --}}
    <div
        x-show="showAlertModal"
        x-cloak
        style="position:fixed;inset:0;z-index:1000;background:rgba(9,16,122,0.55);backdrop-filter:blur(4px);"
    >
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;border-radius:18px;max-width:560px;width:calc(100% - 3rem);box-shadow:0 32px 64px rgba(9,16,122,0.28);overflow:hidden;">
            {{-- Header --}}
            <div style="background:linear-gradient(135deg,#09107a 0%,#1a24d2 100%);padding:1.1rem 2rem;display:flex;align-items:center;justify-content:space-between;">
                <h3 style="font-family:'Cinzel',serif;font-size:1.3rem;font-weight:700;color:#fff;letter-spacing:0.03em;margin:0;" x-text="alertModalTitle"></h3>
                <svg width="32" height="32" fill="none" stroke="#f5b800" stroke-width="2.5" viewBox="0 0 24 24" style="flex-shrink:0;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
            </div>
            {{-- Body --}}
            <div style="padding:1rem 2rem 1.75rem;">
                <p style="font-family:'Nunito Sans',sans-serif;font-size:0.95rem;color:#10233f;line-height:1.7;margin:0 0 1rem;" x-text="alertModalMessage"></p>
                <template x-if="alertModalItems.length > 0">
                    <ul style="margin:0 0 1.5rem;padding:0;list-style:none;">
                        <template x-for="item in alertModalItems" :key="item">
                            <li style="font-family:'Nunito Sans',sans-serif;font-size:0.9rem;color:#10233f;padding:0.45rem 0.9rem;border-left:3px solid #f5b800;margin-bottom:0.5rem;border-radius:0 6px 6px 0;background:#fffbf0;" x-text="item"></li>
                        </template>
                    </ul>
                </template>
                <button @click="showAlertModal = false" style="width:100%;padding:0.85rem 1rem;background:#09107a;color:#fff;border:none;border-radius:9px;font-family:'Nunito Sans',sans-serif;font-size:0.95rem;font-weight:700;cursor:pointer;transition:background 0.15s;" onmouseover="this.style.background='#1a24d2'" onmouseout="this.style.background='#09107a'">Got it</button>
            </div>
        </div>
    </div>

    {{-- Submission Success Modal --}}
    <div
        x-show="showSuccessModal"
        x-cloak
        style="position:fixed;inset:0;z-index:999;background:rgba(9,16,122,0.55);backdrop-filter:blur(4px);"
    >
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:#fff;border-radius:18px;max-width:680px;width:calc(100% - 3rem);box-shadow:0 32px 64px rgba(9,16,122,0.28);overflow:hidden;">
            {{-- Modal top bar --}}
            <div style="background:linear-gradient(135deg,#09107a 0%,#1a24d2 100%);padding:2.25rem 2.5rem 2rem;display:flex;align-items:center;justify-content:space-between;">
                <div>
                    <h2 style="font-family:'Cinzel',serif;font-size:1.9rem;font-weight:700;color:#fff;letter-spacing:0.03em;margin:0 0 0.1rem;">Survey Submitted!</h2>
                    <p style="font-family:'Nunito Sans',sans-serif;font-size:0.88rem;color:rgba(255,255,255,0.65);margin:0;">Ateneo Graduate Tracer Study</p>
                </div>
                <div style="width:64px;height:64px;background:rgba(255,255,255,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg width="34" height="34" fill="none" stroke="#f5b800" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>
            {{-- Modal body --}}
            <div style="padding:2.25rem 2.5rem;">
                <p style="font-family:'Nunito Sans',sans-serif;font-size:1rem;color:#10233f;line-height:1.75;margin:0 0 1.25rem;">
                    Thank you for completing the <strong>Graduate Tracer Survey!</strong> Your valuable responses will help us improve our academic programs and services.
                </p>
                <div style="background:#fffbf0;border:1.5px solid #f5b800;border-radius:10px;padding:1rem 1.25rem;margin-bottom:1.75rem;">
                    <p style="font-family:'Nunito Sans',sans-serif;font-size:0.93rem;color:#10233f;line-height:1.7;margin:0;">
                        As a token of appreciation for your time and effort, you are entitled to participate in the <strong>raffle</strong> for a chance to win an <strong>official AdDU polo shirt!</strong>
                    </p>
                </div>
                <a href="/" style="display:flex;align-items:center;justify-content:center;width:100%;padding:0.9rem 1rem;background:#09107a;color:#fff;border-radius:9px;font-family:'Nunito Sans',sans-serif;font-size:0.95rem;font-weight:700;text-decoration:none;transition:background 0.15s;" onmouseover="this.style.background='#1a24d2'" onmouseout="this.style.background='#09107a'">
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
        showAlertModal: false,
        alertModalTitle: '',
        alertModalMessage: '',
        alertModalItems: [],
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

        init() {
            this.syncAutoCalculatedAge();
            // Prevent users from using the Back button to return to the welcome page
            try {
                history.pushState(null, '', location.href);
                window.addEventListener('popstate', () => {
                    history.pushState(null, '', location.href);
                });
            } catch (e) {
                // ignore
            }
            fetch('https://restcountries.com/v3.1/all?fields=name')
                .then(r => r.json())
                .then(data => {
                    this.countries = data
                        .map(c => c.name.common)
                        .sort((a, b) => a.localeCompare(b));
                })
                .catch(() => {});
            fetch('https://psgc.gitlab.io/api/regions/')
                .then(r => r.json())
                .then(data => {
                    const order = {
                        'Region I': 1, 'Region II': 2, 'Region III': 3,
                        'Region IV-A': 4, 'Region IV-B': 5, 'Region V': 6,
                        'Region VI': 7, 'Region VII': 8, 'Region VIII': 9,
                        'Region IX': 10, 'Region X': 11, 'Region XI': 12,
                        'Region XII': 13, 'Region XIII': 14,
                        'NCR': 15, 'CAR': 16, 'NIR': 17, 'BARMM': 18,
                    };
                    this.psgc.regions = (Array.isArray(data) ? data : [])
                        .sort((a, b) => (order[a.regionName] || 99) - (order[b.regionName] || 99));
                })
                .catch(() => {});
        },

        get totalSections() {
            return this.categories.length;
        },

        get totalQuestionsCount() {
            let total = 0;
            this.categories.forEach(cat => {
                (cat.questions || []).forEach(q => { if (q.type !== 'display') total++; });
            });
            return total;
        },

        get answeredQuestionsCount() {
            let answered = 0;
            this.categories.forEach(cat => {
                (cat.questions || []).forEach(q => {
                    if (q.type !== 'display') {
                        const v = this.formData[q.id];
                        if (v !== undefined && v !== null && v !== '') answered++;
                    }
                });
            });
            return answered;
        },

        get answeredProgress() {
            if (this.totalQuestionsCount === 0) return 0;
            return Math.round(this.answeredQuestionsCount / this.totalQuestionsCount * 100);
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
            return filtered.slice(0, 80);
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
                fetch('https://psgc.gitlab.io/api/regions/' + code + '/provinces/')
                    .then(r => r.json())
                    .then(data => {
                        this.psgc.provinces = (Array.isArray(data) ? data : [])
                            .sort((a, b) => a.name.localeCompare(b.name));
                    })
                    .catch(() => {});
            } else if (question.type === 'province_select') {
                this.psgc.provinceCode = code;
                this.psgc.municipalities = [];
                this.psgc.barangays = [];
                this.psgc.municipalityCode = null;
                this.clearPsgcDownstream('province_select');
                fetch('https://psgc.gitlab.io/api/provinces/' + code + '/cities-municipalities/')
                    .then(r => r.json())
                    .then(data => {
                        this.psgc.municipalities = (Array.isArray(data) ? data : [])
                            .sort((a, b) => a.name.localeCompare(b.name));
                    })
                    .catch(() => {});
            } else if (question.type === 'municipality_select') {
                this.psgc.municipalityCode = code;
                this.psgc.barangays = [];
                this.clearPsgcDownstream('municipality_select');
                fetch('https://psgc.gitlab.io/api/cities-municipalities/' + code + '/barangays/')
                    .then(r => r.json())
                    .then(data => {
                        this.psgc.barangays = (Array.isArray(data) ? data : [])
                            .sort((a, b) => a.name.localeCompare(b.name));
                    })
                    .catch(() => {});
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
            let sourceQuestionId = null;

            if (question.repeating_ref) {
                sourceQuestionId = this.findQuestionIdByRef(question.repeating_ref);
            }

            // Backward-compatible fallback: use the condition question as the count source.
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
                } else if (question.type === 'repeating_text') {
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
                this.showAlert('Missing Questions', 'Please answer the required questions before continuing:', missing);
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
                this.showAlert('Save Error', 'An error occurred while saving. Please try again.');
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
                this.showAlert('Copied!', 'Resume code copied to clipboard.');
            }
        },

        showAlert(title, message, items = []) {
            this.alertModalTitle = title;
            this.alertModalMessage = message;
            this.alertModalItems = items;
            this.showAlertModal = true;
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
                    this.showAlert('Submit Failed', 'Failed to submit. Please try again.');
                }
            } catch {
                this.showAlert('Error', 'An error occurred. Please try again.');
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
    background: linear-gradient(90deg, #f5b800 0%, #e0a800 55%, #f5b800 100%);
    box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.15) inset, 0 2px 10px rgba(245, 184, 0, 0.35);
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
