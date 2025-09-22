<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PodcastController;
use App\Http\Controllers\ContactController;
use App\Models\Interview;
use App\Models\Category;

// Redirect root to appropriate page
Route::get('/', function () {

$OmanInterviews = Interview::with('Category')
        ->whereHas('Category', function($q) {
            $q->where('name', 'Oman');
        })->get();

    $UAEInterviews = Interview::with('Category')
        ->whereHas('Category', function($q) {
            $q->where('name', 'UAE');
        })->get();

    $KSInterviews = Interview::with('Category')
        ->whereHas('Category', function($q) {
            $q->where('name', 'Saudi Arabia');
        })->get();

    $QatarInterviews = Interview::with('Category')
        ->whereHas('Category', function($q) {
            $q->where('name', 'Qatar');
        })->get();

    $KuwaitInterviews = Interview::with('Category')
        ->whereHas('Category', function($q) {
            $q->where('name', 'Kuwait');
        })->get();

    $BahrainInterviews = Interview::with('Category')
        ->whereHas('Category', function($q) {
            $q->where('name', 'Bahrain');
        })->get();


    return auth()->check() ? redirect()->route('admin.dashboard') : view('welcome', compact( 'OmanInterviews', 'UAEInterviews', 'KSInterviews', 'QatarInterviews', 'KuwaitInterviews', 'BahrainInterviews'));
});

//contact form routes
Route::post('/contact', [ContactController::class, 'submitContactForm'])->name('contact.submit');

// Public content routes
Route::get('/events', [EventController::class, 'publicIndex'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'publicShow'])->name('events.show');
Route::get('/interviews', [InterviewController::class, 'publicIndex'])->name('interviews.index');
Route::get('/interviews/{interview}', [InterviewController::class, 'publicShow'])->name('interviews.show');
Route::get('/podcasts', [PodcastController::class, 'publicIndex'])->name('podcasts.index');
Route::get('/podcasts/{podcast}', [PodcastController::class, 'publicShow'])->name('podcasts.show');
Route::get('/podcasts/{podcast}/stream', [PodcastController::class, 'stream'])->name('podcasts.stream');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Admin Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Categories Management
    Route::resource('categories', CategoryController::class);
    Route::post('categories/{category}/toggle', [CategoryController::class, 'toggle'])->name('categories.toggle');
    
    // Interviews Management
    Route::resource('interviews', InterviewController::class);
    Route::get('interviews/category/{category}', [InterviewController::class, 'byCategory'])->name('interviews.by-category');
    
    // Events Management
    Route::resource('events', EventController::class);
    Route::get('events/upcoming', [EventController::class, 'upcoming'])->name('events.upcoming');
    Route::get('events/category/{category}', [EventController::class, 'byCategory'])->name('events.by-category');
    Route::patch('events/{event}/publish', [EventController::class, 'publish'])->name('events.publish');
    Route::patch('events/{event}/unpublish', [EventController::class, 'unpublish'])->name('events.unpublish');
    Route::delete('events/{event}/remove-image', [EventController::class, 'removeImage'])->name('events.remove-image');
    
    // Podcasts Management
    Route::resource('podcasts', PodcastController::class);
    Route::get('podcasts/latest', [PodcastController::class, 'latest'])->name('podcasts.latest');
    Route::get('podcasts/category/{category}', [PodcastController::class, 'byCategory'])->name('podcasts.by-category');
    Route::get('podcasts/{podcast}/stream', [PodcastController::class, 'stream'])->name('podcasts.stream');
    Route::patch('podcasts/{podcast}/publish', [PodcastController::class, 'publish'])->name('podcasts.publish');
    Route::patch('podcasts/{podcast}/unpublish', [PodcastController::class, 'unpublish'])->name('podcasts.unpublish');
    Route::delete('podcasts/{podcast}/remove-audio', [PodcastController::class, 'removeAudio'])->name('podcasts.remove-audio');
    
    // Contact Messages Management
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::delete('contacts', [ContactController::class, 'bulkDelete'])->name('contacts.bulk-delete');
    Route::patch('contacts/{contact}/read', [ContactController::class, 'markAsRead'])->name('contacts.mark-read');
    
    // Users Management (if needed)
    // Route::resource('users', UserController::class);
});

// API Routes for AJAX calls

