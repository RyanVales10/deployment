<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Survey routes
Route::get('/', [SurveyController::class, 'welcome']);
Route::get('/survey', [SurveyController::class, 'index']);
Route::post('/survey/check-email', [SurveyController::class, 'checkEmail']);
Route::post('/survey/submit', [SurveyController::class, 'submit']);
Route::post('/survey/save-draft', [SurveyController::class, 'saveDraft']);
Route::post('/survey/resume', [SurveyController::class, 'resume']);

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
});

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Public admin login page (shows login form at /admin)
Route::get('/admin', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('admin.login');

// Protected admin routes (require admin middleware)
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/responses', [AdminController::class, 'responses']);
    Route::get('/responses/{id}/details', [AdminController::class, 'responseDetails']);
    Route::get('/export-csv', [AdminController::class, 'exportCsv']);

    // Admin API (categories / questions CRUD)
    Route::get('/api/categories', [AdminController::class, 'categoriesJson']);
    Route::post('/api/categories', [AdminController::class, 'storeCategory']);
    Route::put('/api/categories/{id}', [AdminController::class, 'updateCategory']);
    Route::delete('/api/categories/{id}', [AdminController::class, 'deleteCategory']);
    Route::post('/api/questions', [AdminController::class, 'storeQuestion']);
    Route::post('/api/questions/reorder', [AdminController::class, 'reorderQuestions']);
    Route::put('/api/questions/{id}', [AdminController::class, 'updateQuestion']);
    Route::delete('/api/questions/{id}', [AdminController::class, 'deleteQuestion']);
});
