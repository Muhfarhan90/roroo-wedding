<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('clients', ClientController::class);
    Route::get('orders-timeline', [OrderController::class, 'timeline'])->name('orders.timeline');
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/add-payment', [OrderController::class, 'addPayment'])->name('orders.add-payment');
    Route::post('orders/{order}/create-invoice', [OrderController::class, 'createInvoice'])->name('orders.create-invoice');
    Route::get('orders/{order}/download-pdf', [OrderController::class, 'downloadPdf'])->name('orders.download-pdf');
    Route::post('orders/sync-payments', [OrderController::class, 'syncPayments'])->name('orders.sync-payments');

    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/download-pdf', [InvoiceController::class, 'downloadPdf'])->name('invoices.download-pdf');

    Route::get('calendar', [AppointmentController::class, 'index'])->name('calendar.index');
    Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('appointments/{id}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::put('appointments/{id}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
});
