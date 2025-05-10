<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/invoices/{invoice}/details', function (App\Models\Invoice $invoice) {
    return response()->json([
        'success' => true,
        'client_id' => $invoice->client_id,
        'client_name' => $invoice->client->name,
        'balance' => $invoice->balance
    ]);
});
