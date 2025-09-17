<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        return view('admin.bookings.index', [
            'bookings' => Booking::latest()->with('trips')->get(),
        ]);
    }

    public function show(Booking $booking): View
    {
        return view('admin.bookings.show', [
            'booking' => $booking,
        ]);
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return back()->with('success_message', 'Booking deleted successfully.');
    }
}
