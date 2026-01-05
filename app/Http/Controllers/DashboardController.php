<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total counts
        $totalClients = Client::count();
        $totalOrders = Order::count();
        $totalInvoices = Invoice::count();

        // Calculate total revenue from paid amounts in orders
        $totalRevenue = Order::sum('total_amount') - Order::sum('remaining_amount');

        // Get recent 5 orders with client information
        $recentOrders = Order::with('client')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Monthly revenue for last 6 months
        $monthlyRevenue = Order::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(total_amount - remaining_amount) as revenue')
        )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Payment status distribution
        $paymentStatus = [
            'lunas' => Order::where('payment_status', 'Lunas')->count(),
            'belum_lunas' => Order::where('payment_status', 'Belum Lunas')->count(),
        ];

        // Invoice status distribution
        $invoiceStatus = [
            'paid' => Invoice::where('status', 'Paid')->count(),
            'partial' => Invoice::where('status', 'Partial')->count(),
            'unpaid' => Invoice::where('status', 'Unpaid')->count(),
        ];

        // Upcoming events (next 30 days)
        $upcomingEvents = Client::where(function ($query) {
            $query->whereBetween('akad_date', [Carbon::now(), Carbon::now()->addDays(30)])
                ->orWhereBetween('reception_date', [Carbon::now(), Carbon::now()->addDays(30)]);
        })
            ->orderBy('akad_date')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalClients',
            'totalOrders',
            'totalInvoices',
            'totalRevenue',
            'recentOrders',
            'monthlyRevenue',
            'paymentStatus',
            'invoiceStatus',
            'upcomingEvents'
        ));
    }
}
