<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RoomController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Room::class, 'room');
    }

    /**
     * Get the map of resource methods to ability names.
     *
     * @return array
     */
    protected function resourceAbilityMap(): array
    {
        return [
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $offerId
     * @return View
     * @throws AuthorizationException
     */
    public function create(int $offerId): View
    {
        $offer = Offer::findOrFail($offerId);
        $this->authorize('create', [Room::class, $offer->user_id]);
        return view('rooms.create', ['offer' => $offer]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRoomRequest $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreRoomRequest $request): RedirectResponse
    {
        $offer = Offer::findOrFail($request->offer_id);
        $this->authorize('create', [Room::class, $offer->user_id]);
        $requestData = $request->all();
        $room = Room::create($requestData);
        return redirect()->route('offers.show', $room->offer_id);
    }

    /**
     * Display the specified resource.
     *
     * @param Room $room
     * @return View
     * @throws AuthorizationException
     */
    public function show(Room $room): View
    {
        $room = Room::findOrFail($room->id);
        $disabledDates = $room->reservations->map(function ($reservation) {
            return [
                'start' => $reservation->date_from,
                'end' => $reservation->date_to,
            ];
        });

        return view('rooms.show', [
            'room' => $room,
            'disabledDates' => $disabledDates
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Room $room
     * @return View
     */
    public function edit(Room $room): View
    {
        $room = Room::findOrFail($room->id);
        $offer = $room->offer;
        return view('rooms.create', ['room' => $room, 'offer' => $offer]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoomRequest $request
     * @param Room $room
     * @return RedirectResponse
     */
    public function update(UpdateRoomRequest $request, Room $room): RedirectResponse
    {
        $room = Room::findOrFail($room->id);
        $input = $request->all();
        $room->update($input);
        return redirect()->route('rooms.show', $room->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $room): RedirectResponse
    {
        $room = Room::findOrFail($room->id);
        $room->delete();
        return redirect()->route('offers.show', $room->offer_id);
    }
}
