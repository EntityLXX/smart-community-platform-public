<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\User\EventController as UserEventController;
use App\Http\Controllers\User\FacilityBookingController as UserBookingController;
use App\Http\Controllers\Admin\FacilityBookingController as AdminBookingController;
use App\Http\Controllers\Admin\FinancialTransactionController;
use App\Http\Controllers\Admin\ChoiceController;
use App\Http\Controllers\Admin\VotingController;
use App\Http\Controllers\User\VotingController as UserVotingController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Communication-Hub
    Route::get('/communication-hub', [ThreadController::class, 'index'])->name('threads.index');
    Route::get('/communication-hub/create', [ThreadController::class, 'create'])->name('threads.create');
    Route::post('/communication-hub', [ThreadController::class, 'store'])->name('threads.store');
    Route::get('/communication-hub/{thread}', [ThreadController::class, 'show'])->name('threads.show');
    Route::delete('/communication-hub/{thread}', [ThreadController::class, 'destroy'])->name('threads.destroy');
    Route::get('/communication-hub/{thread}/edit', [ThreadController::class, 'edit'])->name('threads.edit');
    Route::put('/communication-hub/{thread}', [ThreadController::class, 'update'])->name('threads.update');
    Route::delete('/threads/{thread}/moderate', [ThreadController::class, 'destroyWithReason'])->name('threads.destroyWithReason');

    // Comments
    Route::post('/threads/{thread}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::delete('/comments/{comment}/reason', [CommentController::class, 'destroyWithReason'])->name('comments.destroyWithReason');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::patch('/notifications/mark-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAll');

});

// Admin dashboard + Event routes (only for role:admin)
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->as('admin.') 
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('events', EventController::class);

        // User Management
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
        Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
        Route::patch('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/toggle-role', [AdminUserController::class, 'toggleRole'])->name('users.toggleRole');
        Route::patch('/users/{user}/toggle-facility-access', [AdminUserController::class, 'toggleFacilityAccess'])->name('users.toggleFacilityAccess');


        // Calendar-tracking
        Route::get('facility-bookings/calendar-data', [AdminBookingController::class, 'calendarData']);
        
        // Admin: Handle and approve/reject bookings
        Route::get('facility-bookings', [AdminBookingController::class, 'index'])->name('facility-bookings.index');
        Route::get('facility-bookings/{id}', [AdminBookingController::class, 'show'])->name('facility-bookings.show');
        Route::patch('facility-bookings/{id}/approve', [AdminBookingController::class, 'approve'])->name('facility-bookings.approve');
        Route::patch('facility-bookings/{id}/reject', [AdminBookingController::class, 'reject'])->name('facility-bookings.reject');

        // Financial Management
        Route::get('finance', [FinancialTransactionController::class, 'index'])->name('finance.index');
        Route::get('finance/create/{type}', [FinancialTransactionController::class, 'create'])->name('finance.create');
        Route::post('finance/store', [FinancialTransactionController::class, 'store'])->name('finance.store');
        Route::get('finance/history', [FinancialTransactionController::class, 'history'])->name('finance.history');
        Route::get('finance/{id}/edit', [FinancialTransactionController::class, 'edit'])->name('finance.edit');
        Route::put('finance/{id}', [FinancialTransactionController::class, 'update'])->name('finance.update');
        Route::delete('finance/{id}', [FinancialTransactionController::class, 'destroy'])->name('finance.destroy');
        Route::get('finance/chart/category-summary', [FinancialTransactionController::class, 'categorySummary'])->name('finance.chart.category-summary');
        Route::get('finance/export', [FinancialTransactionController::class, 'export'])->name('finance.export');


        // Votings
        Route::resource('votings', VotingController::class);
        Route::patch('votings/{voting}/end', [VotingController::class, 'endVoting'])->name('votings.end');

        Route::prefix('votings/{voting}')->name('votings.')->group(function () {
            Route::get('choices/create', [ChoiceController::class, 'create'])->name('choices.create');
            Route::post('choices', [ChoiceController::class, 'store'])->name('choices.store');
            Route::get('choices/{choice}/edit', [ChoiceController::class, 'edit'])->name('choices.edit');
            Route::put('choices/{choice}', [ChoiceController::class, 'update'])->name('choices.update');
            Route::delete('choices/{choice}', [ChoiceController::class, 'destroy'])->name('choices.destroy');
        });

});


Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {

    // User Dashboard
    Route::middleware('role:user')->group(function () {
        // Dashboard 
        Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');
        
    });

    // Shared Event Viewing (for both admin and user)
    Route::get('/events', [UserEventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [UserEventController::class, 'show'])->name('events.show');

    // Facility Booking (only for role:user)
    Route::get('facility-bookings', [UserBookingController::class, 'index'])->name('facility-bookings.index');
    Route::get('facility-bookings/create', [UserBookingController::class, 'create'])->name('facility-bookings.create');
    Route::post('facility-bookings', [UserBookingController::class, 'store'])->name('facility-bookings.store');
    Route::get('facility-bookings/{id}', [UserBookingController::class, 'show'])->name('facility-bookings.show');
    Route::delete('facility-bookings/{id}', [UserBookingController::class, 'destroy'])->name('facility-bookings.destroy');

    // Voting
    Route::get('/votings', [UserVotingController::class, 'index'])->name('votings.index');
    Route::get('/votings/{voting}', [UserVotingController::class, 'show'])->name('votings.show');
    Route::post('/votings/{voting}/vote', [UserVotingController::class, 'vote'])->name('votings.vote');

});
    


require __DIR__.'/auth.php';
