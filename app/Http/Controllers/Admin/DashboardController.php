<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('payment_status', PaymentStatus::PAID)->sum('grand_total');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();

        $recentOrders = Order::with('user')->latest()->take(5)->get();
        $lowStockProducts = Product::where('stock', '<=', 5)->take(5)->get();

        // Monthly sales metrics (last 6 months)
        $salesMetrics = Order::select(
            DB::raw('SUM(grand_total) as revenue'),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
        )
        ->where('payment_status', PaymentStatus::PAID)
        ->groupBy('month')
        ->orderBy('month', 'desc')
        ->take(6)
        ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'recentOrders',
            'lowStockProducts',
            'salesMetrics'
        ));
    }
}
