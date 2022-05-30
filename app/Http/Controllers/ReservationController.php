<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Room;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReservationController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Reservation::class, 'reservation');
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        DB::select('call get_reservations_for_user(?)', [Auth::id()]);

        return view('reservations.index', [
            'reservations' => Reservation::where('user_id', Auth::id())->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $roomId
     * @return View
     */
    public function create(int $roomId): View
    {
        $room = Room::findOrFail($roomId);
        $disabledDates = $room->reservations->map(function ($reservation) {
            return [
                'start' => $reservation->date_from,
                'end' => $reservation->date_to,
            ];
        });
        return view("reservations.create", ["room" => $room, "offer" => $room->offer, "disabledDates" => $disabledDates]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreReservationRequest  $request
     * @return RedirectResponse
     */
    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $requestData = $request->all();
        $requestData['user_id'] = Auth::id();
        Reservation::create($requestData);
        return redirect()->route('reservations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Reservation $reservation
     * @return View
     */
    public function show(Reservation $reservation): View
    {
        $dateFrom = Date::createFromFormat('Y-m-d', $reservation->date_from);
        $dateTo = Date::createFromFormat('Y-m-d', $reservation->date_to);
        $totalPrice = $reservation->room->price * $dateTo->diffInDays($dateFrom);

        return view('reservations.show', ['reservation' => $reservation, 'totalPrice' => $totalPrice]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReservationRequest  $request
     * @param Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
