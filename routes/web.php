<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IssueCommentController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\IssueMemberController;
use App\Http\Controllers\IssueTagController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TagIssueController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('projects.index')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('projects', ProjectController::class);
    Route::get('/issues/search', [IssueController::class, 'search'])->name('issues.search');
    Route::resource('issues', IssueController::class);
    Route::resource('tags', TagController::class)->only(['index', 'store', 'show']);

    Route::get('/issues/{issue}/tags-manager', [IssueTagController::class, 'manager'])->name('issues.tags.manager');
    Route::get('/tags/{tag}/issues-manager', [TagIssueController::class, 'manager'])->name('tags.issues.manager');
    Route::get('/issues/{issue}/comments', [IssueCommentController::class, 'index'])->name('issues.comments.index');
    Route::post('/issues/{issue}/comments', [IssueCommentController::class, 'store'])->name('issues.comments.store');

    Route::post('/issues/{issue}/tags/{tag}', [IssueTagController::class, 'store'])->name('issues.tags.store');
    Route::delete('/issues/{issue}/tags/{tag}', [IssueTagController::class, 'destroy'])->name('issues.tags.destroy');
    Route::post('/tags/{tag}/issues/{issue}', [TagIssueController::class, 'store'])->name('tags.issues.store');
    Route::delete('/tags/{tag}/issues/{issue}', [TagIssueController::class, 'destroy'])->name('tags.issues.destroy');

    Route::post('/issues/{issue}/members/{user}', [IssueMemberController::class, 'store'])->name('issues.members.store');
    Route::delete('/issues/{issue}/members/{user}', [IssueMemberController::class, 'destroy'])->name('issues.members.destroy');
});
