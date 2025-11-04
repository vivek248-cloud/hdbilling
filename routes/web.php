<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', function() {
    return view('home');
})->name('home');

// Admin & general login routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Resources
    Route::resource('users', UserController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('payments', PaymentController::class);





    Route::get('projects/{id}/payments', [ProjectController::class, 'showPayments'])->name('projects.payments');
});



// invoice
// ✅ Accessible by both Admin and Client
Route::middleware(['auth'])->group(function () {

    Route::get('/payments/invoice/{paymentId}', [PaymentController::class, 'invoice'])
        ->name('payments.invoice');

        // share whatsapp link for invoice
    Route::get('/invoice/temp/{payment}', [PaymentController::class, 'temporaryInvoice'])
    ->name('payments.temp_invoice');
});




// Client login routes
Route::prefix('client')->group(function () {
    Route::get('login', [ClientLoginController::class, 'showLoginForm'])->name('client.login');
    Route::post('login', [ClientLoginController::class, 'login'])->name('client.login.submit');
    Route::post('logout', [ClientLoginController::class, 'logout'])->name('client.logout');

    // Client dashboard (requires auth)
    Route::middleware(['auth'])->group(function () {
        Route::get('dashboard', [ClientLoginController::class, 'dashboard'])->name('client.dashboard');
    });
});




Route::get('/projects/{project}/expenses', [ExpenseController::class, 'showProjectExpenses'])
    ->name('projects.details');







