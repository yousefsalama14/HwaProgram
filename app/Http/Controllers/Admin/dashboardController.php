<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Orderdetailes;
use Illuminate\Http\Request;
use Carbon\Carbon;

class dashboardController extends Controller
{
    public function index(Request $request){
        try {
            // Initialize default values
            $totalRevenue = 0;
            $todayRevenue = 0;
            $totalOrdersCount = 0;
            $todayOrdersCount = 0;
            $recentOrders = collect();
            $dailyProfits = [];
            $revenueByOperation = [];
            $selectedDate = Carbon::today()->format('Y-m-d');

            // Calculate total revenue from all paid orders by summing order details
            $totalRevenue = Order::where('status', 'paied')
                ->with('orderdetailes')
                ->get()
                ->sum(function($order) {
                    return $order->orderdetailes->sum('price');
                }) ?? 0;

            // Calculate today's revenue
            $todayRevenue = Order::where('status', 'paied')
                ->whereDate('paid_at', Carbon::today())
                ->with('orderdetailes')
                ->get()
                ->sum(function($order) {
                    return $order->orderdetailes->sum('price');
                }) ?? 0;

            // Count total orders (only paid orders)
            $totalOrdersCount = Order::where('status', 'paied')
                ->count() ?? 0;

            // Count today's orders (only paid orders)
            $todayOrdersCount = Order::where('status', 'paied')
                ->whereDate('paid_at', Carbon::today())
                ->count() ?? 0;

            // Get recent orders for the reports table
            $recentOrders = Order::with('orderdetailes')
                ->where('status', 'paied')
                ->orderBy('paid_at', 'desc')
                ->limit(7)
                ->get();

            // Calculate daily profits for the last 7 days
            $dailyProfits = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $dayRevenue = Order::where('status', 'paied')
                    ->whereDate('paid_at', $date)
                    ->with('orderdetailes')
                    ->get()
                    ->sum(function($order) {
                        return $order->orderdetailes->sum('price');
                    }) ?? 0;

                $dayOrdersCount = Order::where('status', 'paied')
                    ->whereDate('paid_at', $date)
                    ->count() ?? 0;

                $dailyProfits[] = [
                    'date' => $date->format('d M'),
                    'orders_count' => $dayOrdersCount,
                    'revenue' => $dayRevenue
                ];
            }

            // Get revenue by operation type for the chart
            $selectedDate = $request->get('chart_date', Carbon::today()->format('Y-m-d'));
            $revenueByOperation = $this->getRevenueByOperation($selectedDate);

        } catch (\Exception $e) {
            // Log the error and set default values
            \Log::error('Dashboard Controller Error: ' . $e->getMessage());

            // Ensure all variables have default values
            $totalRevenue = $totalRevenue ?? 0;
            $todayRevenue = $todayRevenue ?? 0;
            $totalOrdersCount = $totalOrdersCount ?? 0;
            $todayOrdersCount = $todayOrdersCount ?? 0;
            $recentOrders = $recentOrders ?? collect();
            $dailyProfits = $dailyProfits ?? [];
            $revenueByOperation = $revenueByOperation ?? [];
            $selectedDate = $selectedDate ?? Carbon::today()->format('Y-m-d');
        }

        return view('Admin.dashboard.index', compact(
            'totalRevenue',
            'todayRevenue',
            'totalOrdersCount',
            'todayOrdersCount',
            'recentOrders',
            'dailyProfits',
            'revenueByOperation',
            'selectedDate'
        ));
    }

    private function getRevenueByOperation($date)
    {
        $operations = [
            'اللحام' => 1,
            'الدرفلة' => 2,
            'التقطيع' => 3,
            'التناية' => 4,
            'التخريم' => 5,
            'الخامات' => 6,
            'الخامات الاستاندرد' => 7
        ];

        $revenueData = [];

        foreach ($operations as $operationName => $operationId) {
            $revenue = Order::where('status', 'paied')
                ->whereDate('paid_at', $date)
                ->whereHas('orderdetailes.operationdetailes', function($query) use ($operationId) {
                    $query->where('operation_id', $operationId);
                })
                ->with(['orderdetailes' => function($query) use ($operationId) {
                    $query->whereHas('operationdetailes', function($q) use ($operationId) {
                        $q->where('operation_id', $operationId);
                    });
                }])
                ->get()
                ->sum(function($order) {
                    return $order->orderdetailes->sum('price');
                }) ?? 0;

            $revenueData[] = [
                'operation' => $operationName,
                'revenue' => $revenue
            ];
        }

        return $revenueData;
    }
}
