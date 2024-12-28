<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\IdBadge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservationHistoryController extends Controller
{

    public function index()
    {
        $reservations = Reservation::where('user_id', Auth::id())->orderBy('reservation_date', 'desc')->get();

        return view('history.index', ['reservations' => $reservations, 'title' => 'History Reservations']);
    }
}
