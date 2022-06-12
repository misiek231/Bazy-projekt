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

    protected function resourceAbilityMap(): array
    {
        return [
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
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
        $reservationId = DB::insert('Select * from insertReservation(?, ?, ?, ?)',
        [
            $requestData->date_from,
            $requestData->date_to,
            $requestData->room_id,
            $requestData->user_id,
            Auth::id()
        ]);
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
        $reservation = DB::selectOne('select * from getReservationById(?)', [$reservation->id]);
        $user = DB::selectOne('select * from getUserById(?)', [$reservation->user_id]);
        $rooms = DB::selectOne('select * from getRoomById(?)', [$reservation->room_id]);
        $reservation->user = $user;
        $reservation->rooms = $rooms;

        return view('reservation.show', [
            'reservation' => $reservation
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        $reservation = DB::selectOne('select * from getReservationById(?)', [$reservation->id]);
        $user = DB::selectOne('select * from getUserById(?)', [$reservation->user_id]);
        $rooms = DB::selectOne('select * from getRoomById(?)', [$reservation->room_id]);
        $reservation->user = $user;
        $reservation->rooms = $rooms;

        return view('reservation.create
        ', [
            'reservation' => $reservation
        ]);
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
        DB::update('call updateReservation(?, ?, ?, ?, ?)', [$reservation->id,  $request->date_from, $request->date_to, $request->room_id, $request->user_id]);
        return redirect()->route('reservation.show', $reservation->id);
        }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation = DB::selectOne('select * from getReservationById(?)', [$reservation->id]);
        DB::selectOne('call deleteReservationByID(?)', [$reservation->id]);
        return redirect()->route('reservations.my');
        }
}
