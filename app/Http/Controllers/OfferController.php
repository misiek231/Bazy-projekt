<?php

namespace App\Http\Controllers;

use App\Http\Requests\Filters\OfferFilterRequest;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Models\Offer;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

function objectToObject($instance, $className) {
    return unserialize(sprintf(
        'O:%d:"%s"%s',
        strlen($className),
        $className,
        strstr(strstr(serialize($instance), '"'), ':')
    ));
}

class OfferController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Offer::class, 'offer');
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
     * @param OfferFilterRequest $request
     * @return View
     */
    public function index(OfferFilterRequest $request): View
    {
        $offers = DB::select('select * from getFilteredOffers('.
            (isset($request->name) ? '\''.$request->name.'\'' : 'null').', '.
            (isset($request->dateFrom) ? '\''.$request->dateFrom.'\'' : 'null').', '.
            (isset($request->dateTo) ? '\''.$request->dateTo.'\'' : 'null').', '.
            (isset($request->place) ? '\''.$request->place.'\'' : 'null').', '.
            (isset($request->peopleAmount) ? '\''.$request->peopleAmount.'\'' : 'null').', '.
            (isset($request->accommodationType) ? '\''.$request->accommodationType.'\'' : 'null').', '.
            (isset($request->priceFrom) ? '\''.$request->priceFrom.'\'' : 'null').', '.
            (isset($request->priceTo) ? '\''.$request->priceTo.'\'' : 'null').')');

        foreach ($offers as $offer) {
            $offer->rooms = DB::select('select * from getRoomsByOfferId(?)', [$offer->id]);
        }

        return view('offers.index', [
            'offers' => $offers
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     * @throws AuthorizationException
     */
    public function myOffers(): View
    {
        $this->authorize('viewMy', Offer::class);

        $offers = DB::select('select * from getOfferByUserId(?)', [Auth::id()]);

        foreach ($offers as $offer) {
            $offer->rooms = DB::select('select * from getRoomsByOfferId(?)', [$offer->id]);
        }

        return view('offers.my-offers', [
            'offers' => $offers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('offers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOfferRequest $request
     * @return RedirectResponse
     */
    public function store(StoreOfferRequest $request)
    {
        $fileName = trim($request->image->getClientOriginalName());
        $request->file('image')->storeAs('', $fileName, 'public');

        $offerId = DB::select('Select * from insertOffer(?, ?, ?, ?, ?, ?)',
            [
                $request->name,
                $request->description,
                $request->place,
                $request->accommodationType,
                $fileName,
                Auth::id()
            ]);

        return redirect()->route('offers.show', $offerId[0]->insertoffer);
    }

    /**
     * Display the specified resource.
     *
     * @param Offer $offer
     * @return View
     */
    public function show(Offer $offer): View
    {
        $offer = DB::selectOne('select * from getOfferById(?)', [$offer->id]);
        $user = DB::selectOne('select * from getUserById(?)', [$offer->user_id]);
        $rooms = DB::select('select * from getRoomsByOfferId(?)', [$offer->id]);
        $offer->user = $user;
        $offer->rooms = $rooms;

        return view('offers.show', [
            'offer' => objectToObject($offer, Offer::class)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Offer $offer
     * @return View
     */
    public function edit(Offer $offer): View
    {

        $offer = DB::selectOne('select * from getOfferById(?)', [$offer->id]);
        $user = DB::selectOne('select * from getUserById(?)', [$offer->user_id]);
        $rooms = DB::select('select * from getRoomsByOfferId(?)', [$offer->id]);
        $offer->user = $user;
        $offer->rooms = $rooms;

        return view('offers.create', [
            'offer' => $offer
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateOfferRequest $request
     * @param Offer $offer
     * @return RedirectResponse
     */
    public function update(UpdateOfferRequest $request, Offer $offer): RedirectResponse
    {
        DB::update('call updateOffer(?, ?, ?, ?, ?)', [$offer->id, $request->name, $request->description, $request->place, $request->accommodationType]);

        return redirect()->route('offers.show', $offer->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Offer $offer
     * @return RedirectResponse
     */
    public function destroy(Offer $offer): RedirectResponse
    {

        $offer = DB::selectOne('select * from getOfferById(?)', [$offer->id]);
        DB::select('call deleteRoomsByOfferId(?)', [$offer->id]);
        DB::select('call deleteOffer(?)', [$offer->id]);

        return redirect()->route('offers.my');
    }
}
