<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Simple home redirect
Route::get('/', function () {
    return redirect()->route('login');
});

// Development-only routes
if (app()->environment('local')) {
    Route::get('/dev/login', function() {
        // Create test user if doesn't exist
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password')
            ]
        );
        
        Auth::login($user);
        return redirect('/dashboard');
    });
    
    Route::get('/dev/invoice', function() {
        // Ensure we're logged in
        if (!Auth::check()) {
            return redirect('/dev/login');
        }
        // Create test client if doesn't exist
        $client = \App\Models\Client::firstOrCreate(
            ['email' => 'client@example.com'],
            [
                'name' => 'Test Client',
                'phone' => '1234567890',
                'address' => '123 Test St'
            ]
        );
        // Create test invoice
        $invoice = \App\Models\Invoice::firstOrCreate(
            ['invoice_number' => 'TEST-001'],
            [
                'client_id' => $client->id,
                'invoice_date' => now(),
                'due_date' => now()->addDays(30),
                'subtotal' => 100,
                'gst_amount' => 10,
                'total' => 110,
                'notes' => 'Test invoice'
            ]
        );
        
        return redirect()->route('invoices.show', $invoice);
    });
}

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Client Routes
    Route::resource('clients', ClientController::class);
    
    // Quote Routes
    Route::resource('quotes', QuoteController::class);
    Route::get('quotes/{quote}/pdf', [QuoteController::class, 'pdf'])->name('quotes.pdf');
    Route::post('quotes/{quote}/convert', [QuoteController::class, 'convertToInvoice'])->name('quotes.convert');
    Route::post('quotes/{quote}/approve', [QuoteController::class, 'approve'])->name('quotes.approve');
    Route::post('quotes/{quote}/reject', [QuoteController::class, 'reject'])->name('quotes.reject');
    
    // Invoice Routes
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('invoices.pdf');
    Route::get('invoices/recurring', [InvoiceController::class, 'recurring'])->name('invoices.recurring');
    Route::post('invoices/{invoice}/send', [InvoiceController::class, 'sendEmail'])->name('invoices.send');
    
    // Product Routes
    Route::resource('products', ProductController::class);
    
    // Payment Routes
    Route::resource('payments', PaymentController::class);
    
    // Report Routes
    Route::get('reports/tax-summary', [ReportController::class, 'taxSummary'])->name('reports.tax-summary');
    Route::get('reports/client-statement', [ReportController::class, 'clientStatement'])->name('reports.client-statement');
    Route::get('reports/revenue-by-client', [ReportController::class, 'revenueByClient'])->name('reports.revenue-by-client');
    Route::get('reports/item-sales', [ReportController::class, 'itemSales'])->name('reports.item-sales');
    Route::get('reports/payments-collected', [ReportController::class, 'paymentsCollected'])->name('reports.payments-collected');
    
    // Settings Routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/settings/email', [SettingsController::class, 'email'])->name('settings.email');
    Route::post('/settings/email', [SettingsController::class, 'updateEmail'])->name('settings.email.update');
    Route::get('/settings/templates', [SettingsController::class, 'templates'])->name('settings.templates');
    Route::post('/settings/templates', [SettingsController::class, 'updateTemplates'])->name('settings.templates.update');
});

require __DIR__.'/auth.php';