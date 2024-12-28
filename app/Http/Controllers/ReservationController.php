<?php

namespace App\Http\Controllers;

use App\Exports\ReservationsExport;
use App\Models\Reservation;
use App\Models\IdBadge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReservationController extends Controller
{

    public function index()
    {
        $reservations = Reservation::with(['user.idBadges'])->orderBy('reservation_date', 'desc')->get();

        return view('reservation.index', ['reservations' => $reservations, 'title' => 'Reservations']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'reservation_date' => 'required|date',
            'no_reservation' => 'required',
            'item.*' => 'required|int',
            'quantity.*' => 'required|int',
        ]);

        foreach ($request->item as $key => $item) {
            Reservation::create([
                'user_id' => Auth::id(),
                'reservation_date' => $request->reservation_date,
                'no_reservation' => $request->no_reservation,
                'item' => $item,
                'quantity' => $request->quantity[$key],
            ]);
        }

        return redirect()->back()->with('success', 'Reservations created successfully.');
    }


    public function update(Request $request, Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }
        $request->validate([
            'item' => 'required|int',
            'quantity' => 'required|int',
            'no_reservation' => 'required',
            'reservation_date' => 'required|date',
        ]);

        $reservation->update([
            'item' => $request->item,
            'quantity' => $request->quantity,
            'no_reservation' => $request->no_reservation,
            'reservation_date' => $request->reservation_date,
        ]);

        return redirect()->back()->with('success', 'Reservation updated successfully.');
    }

    public function destroy(Reservation $reservation)
    {
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }
        $reservation->delete();

        return redirect()->back()->with('warning', 'Reservation deleted successfully.');
    }

    public function exportAll()
    {
        return Excel::download(new ReservationsExport(), 'all_reservations.xlsx');
    }

    public function exportUser()
    {
        return Excel::download(new ReservationsExport(Auth::id()), 'my_reservations.xlsx');
    }
}
