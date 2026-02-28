<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();
        return view('backend.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'inactiveUsers'
        ));
    }


    public function userChart()
    {
        $year = date('Y');


        $newUsers = DB::table('users')
            ->selectRaw("MONTH(created_at) as month, COUNT(*) as total")
            ->whereYear('created_at', $year)
            ->groupByRaw("MONTH(created_at)")
            ->pluck('total', 'month')
            ->toArray();

        $activeUsers = DB::table('users')
            ->selectRaw("MONTH(created_at) as month, COUNT(*) as total")
            ->whereYear('created_at', $year)
            ->where('status', 'active')
            ->groupByRaw("MONTH(created_at)")
            ->pluck('total', 'month')
            ->toArray();

        $monthlyNew = [];
        $monthlyActive = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthlyNew[] = $newUsers[$i] ?? 0;
            $monthlyActive[] = $activeUsers[$i] ?? 0;
        }

        return response()->json([
            'newUsers' => $monthlyNew,
            'activeUsers' => $monthlyActive
        ]);
    }



    public function totalUserGrowth()
    {
        $now = Carbon::now();

        $currentTotal = User::count();

        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        $previousTotal = User::where('created_at', '<=', $previousMonthEnd)->count();

        if ($previousTotal == 0) {
            $percentage = $currentTotal > 0 ? 100 : 0;
        } else {
            $percentage = (($currentTotal - $previousTotal) / $previousTotal) * 100;
        }

        return response()->json([
            'total' => $currentTotal,
            'previous_total' => $previousTotal,
            'percentage' => round($percentage, 2)
        ]);
    }







    public function userGrowth()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear  = Carbon::now()->year;

        $previousMonth = Carbon::now()->subMonth()->month;

        $currentCount = User::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->count();

        $previousCount = User::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $previousMonth)
            ->count();

        if ($previousCount == 0) {
            $percentage = $currentCount > 0 ? 100 : 0;
        } else {
            $percentage = (($currentCount - $previousCount) / $previousCount) * 100;
        }

        return response()->json([
            'current' => $currentCount,
            'previous' => $previousCount,
            'percentage' => round($percentage, 2)
        ]);
    }


    public function userStatusGrowth()
    {
        $now = Carbon::now();
        $currentMonth = $now->month;
        $currentYear  = $now->year;

        $previous = $now->copy()->subMonth();
        $previousMonth = $previous->month;
        $previousYear  = $previous->year;

        // ===== Current Month =====
        $currentActive = User::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->where('status', 'active')
            ->count();

        $currentInactive = User::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->where('status', 'inactive')
            ->count();

        // ===== Previous Month =====
        $previousActive = User::whereYear('created_at', $previousYear)
            ->whereMonth('created_at', $previousMonth)
            ->where('status', 'active')
            ->count();

        $previousInactive = User::whereYear('created_at', $previousYear)
            ->whereMonth('created_at', $previousMonth)
            ->where('status', 'inactive')
            ->count();

        // ===== Percentage Function =====
        $calculate = function ($current, $previous) {
            if ($previous == 0) {
                return $current > 0 ? 100 : 0;
            }
            return round((($current - $previous) / $previous) * 100, 2);
        };

        return response()->json([
            'active' => [
                'current' => $currentActive,
                'percentage' => $calculate($currentActive, $previousActive)
            ],
            'inactive' => [
                'current' => $currentInactive,
                'percentage' => $calculate($currentInactive, $previousInactive)
            ]
        ]);
    }
}
