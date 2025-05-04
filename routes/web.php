<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
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
    
    // Invoice Routes
    Route::resource('invoices', InvoiceController::class);
    Route::get('invoices/{invoice}/pdf', [InvoiceController::class, 'pdf'])->name('invoices.pdf');
    
    // Client Routes
    Route::resource('clients', ClientController::class);
    
    // Product Routes
    Route::resource('products', ProductController::class);
    
    // Settings Routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';