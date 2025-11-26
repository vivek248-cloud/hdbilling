<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientLoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FloorTypeController;
use App\Http\Controllers\RoomTypeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| All web routes for Home Den Billing System
|--------------------------------------------------------------------------
*/

// ===========================
// 🏠 Public Home Page
// ===========================
Route::get('/', function () {
    return view('home');
})->name('home');

// ===========================
// 🔐 Authentication Routes
// ===========================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===========================
// 🧭 Admin Panel Routes (Requires Admin Role)
// ===========================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Resource Controllers
    Route::resources([
        'users' => UserController::class,
        'projects' => ProjectController::class,
        'expenses' => ExpenseController::class,
        'payments' => PaymentController::class,
        'floor-types' => FloorTypeController::class,
        'room-types' => RoomTypeController::class,
    ]);

    // Show payments for specific project
    Route::get('projects/{id}/payments', [ProjectController::class, 'showPayments'])
        ->name('projects.payments');
});

// ===========================
// 🧾 Invoices (Admin + Client Access)
// ===========================
Route::middleware(['auth'])->group(function () {
    Route::get('/payments/invoice/{paymentId}', [PaymentController::class, 'invoice'])
        ->name('payments.invoice');

    // Temporary public share invoice link (WhatsApp)
    Route::get('/invoice/temp/{payment}', [PaymentController::class, 'temporaryInvoice'])
        ->name('payments.temp_invoice');
});

// ===========================
// 👤 Client Portal Routes
// ===========================
Route::prefix('client')->group(function () {

    // Client Authentication
    Route::get('login', [ClientLoginController::class, 'showLoginForm'])->name('client.login');
    Route::post('login', [ClientLoginController::class, 'login'])->name('client.login.submit');
    Route::post('logout', [ClientLoginController::class, 'logout'])->name('client.logout');

    // Client Dashboard
    Route::middleware(['auth'])->group(function () {
        Route::get('dashboard', [ClientLoginController::class, 'dashboard'])
            ->name('client.dashboard');
    });
});

// ===========================
// 📊 Project Expense Details
// ===========================
Route::get('/projects/{project}/expenses', [ExpenseController::class, 'showProjectExpenses'])
    ->name('projects.details');

// ===========================
// 💰 GST & Discount Update (AJAX)
// ===========================
Route::post('/projects/{project}/update-gst-discount', [ProjectController::class, 'updateGstAndDiscount'])
    ->name('projects.updateGstDiscount')
    ->middleware('auth');

// ===========================
// 🧾 Customer & Product Management
// ===========================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Resources
    Route::resource('users', UserController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('expenses', ExpenseController::class);
    Route::resource('payments', PaymentController::class);

    // ✅ Add customers routes inside admin section
Route::prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::get('/{id}', [CustomerController::class, 'show'])->name('customers.show');
    Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');

    // QUOTATION ROUTES (inside customers prefix)
    Route::get('/{id}/quotation', [CustomerController::class, 'showQuotation'])
         ->name('quotation.show'); // View + Print

    Route::get('/{id}/quotation/pdf', [CustomerController::class, 'downloadQuotation'])
         ->name('quotation.pdf'); // Server PDF
});

// Route::get('quotation/{id}', [CustomerController::class, 'showQuotation'])
//      ->name('quotation.show');
});

use App\Http\Controllers\FullSemiTypeController;
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('fullsemi', FullSemiTypeController::class);
});