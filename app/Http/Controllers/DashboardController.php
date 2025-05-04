<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics.
     */
    public function index()
    {
        // Get counts
        $totalClients = Client::count();
        $totalProducts = Product::count();
        $totalInvoices = Invoice::count();
        
        // Get total revenue
        $totalRevenue = Invoice::sum('total');
        
        // Get recent invoices
        $recentInvoices = Invoice::with('client')
            ->latest()
            ->take(5)
            ->get();
        
        // Get monthly revenue for the current year
        $monthlyRevenue = Invoice::select(
                DB::raw('MONTH(invoice_date) as month'),
                DB::raw('SUM(total) as revenue')
            )
            ->whereYear('invoice_date', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->map(function ($item) {
                return round($item->revenue, 2);
            });
        
        // Fill in missing months with zero
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($monthlyRevenue[$i])) {
                $monthlyRevenue[$i] = 0;
            }
        }
        $monthlyRevenue = $monthlyRevenue->sortKeys();
        
        // Get top clients
        $topClients = Client::select('clients.id', 'clients.name', DB::raw('SUM(invoices.total) as total_spent'))
            ->join('invoices', 'clients.id', '=', 'invoices.client_id')
            ->groupBy('clients.id', 'clients.name')
            ->orderByDesc('total_spent')
            ->take(5)
            ->get();
        
        // Get top products
        $topProducts = Product::select('products.id', 'products.name', DB::raw('SUM(invoice_items.quantity) as total_sold'))
            ->join('invoice_items', 'products.id', '=', 'invoice_items.product_id')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();
        
        return view('dashboard', compact(
            'totalClients',
            'totalProducts',
            'totalInvoices',
            'totalRevenue',
            'recentInvoices',
            'monthlyRevenue',
            'topClients',
            'topProducts'
        ));
    }
}