<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockMovement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $movements = StockMovement::whereDate('created_at', Carbon::today())->orderByDesc('created_at')->get();

        return view('pages.admin.dashboard', compact('movements'));
    }
}
