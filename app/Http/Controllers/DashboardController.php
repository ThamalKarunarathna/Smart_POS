<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        // 1) Total order count of the day (all orders today)
        $todayOrderCount = Order::whereDate('created_at', $today)->count();

        // 2) Total sale of the day (sum grand_total today, only CONFIRMED)
        $todaySalesTotal = Order::whereDate('created_at', $today)
            ->where('status', 'CONFIRMED')
            ->sum('grand_total');

        // 3) Total canceled invoices count of the month
        $monthCanceledCount = Order::whereBetween('created_at', [$monthStart, $monthEnd])
            ->where('status', 'CANCELLED')
            ->count();

        // 4) Total sale of the month (sum grand_total month, only CONFIRMED)
        $monthSalesTotal = Order::whereBetween('created_at', [$monthStart, $monthEnd])
            ->where('status', 'CONFIRMED')
            ->sum('grand_total');

        return view('dashboard', compact(
            'todayOrderCount',
            'todaySalesTotal',
            'monthCanceledCount',
            'monthSalesTotal'
        ));
    }
}
