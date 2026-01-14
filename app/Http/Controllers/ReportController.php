<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Item;
use App\Models\StockLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function salesReport(Request $request)
    {
        $fromDate = $request->input('from_date', date('Y-m-01')); // First day of current month
        $toDate = $request->input('to_date', date('Y-m-d')); // Today
        $customerId = $request->input('customer_id');

        $query = Order::with(['customer', 'items.item'])
            ->where('status', 'confirmed')
            ->whereBetween('created_at', [$fromDate . ' 00:00:00', $toDate . ' 23:59:59']);

        if ($customerId) {
            $query->where('customer_id', $customerId);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        // Calculate totals
        $totalSales = $orders->sum('grand_total');
        $totalPaid = $orders->sum('paid_amount');
        $totalBalance = $orders->sum('balance_amount');

        $customers = Customer::where('is_active', 1)->orderBy('name')->get();

        return view('reports.sales', compact('orders', 'customers', 'fromDate', 'toDate', 'customerId', 'totalSales', 'totalPaid', 'totalBalance'));
    }

    public function stockReport(Request $request)
    {
        $itemId = $request->input('item_id');

        $query = Item::query()
            ->select('items.*')
            ->selectRaw('COALESCE((SELECT SUM(qty_in) FROM stock_ledgers WHERE stock_ledgers.item_id = items.id), 0) as total_qty_in')
            ->selectRaw('COALESCE((SELECT SUM(qty_out) FROM stock_ledgers WHERE stock_ledgers.item_id = items.id), 0) as total_qty_out')
            ->selectRaw('(COALESCE((SELECT SUM(qty_in) FROM stock_ledgers WHERE stock_ledgers.item_id = items.id), 0) - COALESCE((SELECT SUM(qty_out) FROM stock_ledgers WHERE stock_ledgers.item_id = items.id), 0)) as available_stock');

        if ($itemId) {
            $query->where('items.id', $itemId);
        }

        $items = $query->orderBy('name')->get();

        // Get all active items for the filter dropdown
        // Using same pattern as OrderController - status = 1 for active
        $allItems = Item::where('status', 1)->orderBy('name')->get();

        return view('reports.stock', compact('items', 'allItems', 'itemId'));
    }

    public function customerDetailsReport(Request $request)
    {
        $statusFilter = $request->input('status'); // 'all', 'active', 'inactive'

        $query = Customer::query()
            ->select('customers.*')
            ->selectRaw('(SELECT COUNT(*) FROM orders WHERE orders.customer_id = customers.id AND orders.status = "confirmed") as total_orders')
            ->selectRaw('(SELECT COALESCE(SUM(grand_total), 0) FROM orders WHERE orders.customer_id = customers.id AND orders.status = "confirmed") as total_sales')
            ->selectRaw('(SELECT COALESCE(SUM(paid_amount), 0) FROM orders WHERE orders.customer_id = customers.id AND orders.status = "confirmed") as total_paid')
            ->selectRaw('(SELECT COALESCE(SUM(balance_amount), 0) FROM orders WHERE orders.customer_id = customers.id AND orders.status = "confirmed") as total_balance');

        if ($statusFilter === 'active') {
            $query->where('is_active', true);
        } elseif ($statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        $customers = $query->orderBy('name')->get();

        // Calculate summary statistics
        $totalCustomers = Customer::count();
        $activeCustomers = Customer::where('is_active', true)->count();
        $inactiveCustomers = Customer::where('is_active', false)->count();

        return view('reports.customer-details', compact('customers', 'statusFilter', 'totalCustomers', 'activeCustomers', 'inactiveCustomers'));
    }
}
