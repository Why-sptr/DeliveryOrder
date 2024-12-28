<?php

namespace App\Http\Controllers;

use App\Models\IdBadge;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $reservation = Reservation::count();
        $idBadge = IdBadge::count();
        $user = User::role('user')->count();
        $admin = User::role('admin')->count();
        $reservationsChart = Reservation::selectRaw('DATE(reservation_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $chartData = [
            'dates' => $reservationsChart->pluck('date')->toArray(),
            'counts' => $reservationsChart->pluck('count')->toArray(),
        ];

        $reservations = Reservation::with(['user.idBadges'])->take(10)->get();

        return view('index', ['title' => 'Dashboard', 'reservation' => $reservation, 'idBadge' => $idBadge, 'user' => $user, 'admin' => $admin,'chartData' => $chartData, 'reservations' => $reservations]);
    }
}
