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

class OfferController extends Controller
{
    public function __construct()
    {
        // TODO: try to move auth to sql code
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

        // var_dump(Offer::filter($request)->toSql());
        // f_name varchar, f_dateFrom date, f_dateTo date, f_place varchar, f_peopleAmount int, f_accommodationType varchar, f_priceFrom float, f_priceTo float
        $data = [
            $request->name ?? 'null',
            $request->dateFrom,
            $request->dateTo ?? 'null',
            $request->place ?? 'null',
            $request->peopleAmount ?? 'null',
            $request->accommodationType ?? 'null',
            $request->priceFrom ?? 'null',
            $request->priceTo ?? 'null',
        ];

        var_dump($data);

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
            'offers' => $offers //Offer::filter($request)->get(),
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
        $fileName = $request->image->getClientOriginalName();
        $request->file('image')->storeAs('', $fileName, 'public');

        $offerId = DB::insert('Select * from insertOffer(?, ?, ?, ?, ?, ?)',
            [
                $request->name,
                $request->description,
                $request->place,
                $request->accommodationType,
                $fileName,
                Auth::id()
            ]);

        return redirect()->route('offers.show', $offerId);
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
            'offer' => $offer
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
        $offer = DB::selectOne('select * from getOfferById(?)', [$offer->id]);
        $oldFileName = $offer->image;
        $input = $request->all();

        $offer = DB::update('select * from updateOffer(?)', [$input->id, $input->name, $input->description, $input->place, $input->accommodationType, $input->image]);

        if ($request->hasFile('image')) {
            $fileName = $request->image->getClientOriginalName();
            $request->file('image')->storeAs('', $fileName, 'public');
            $offer->image = $fileName;
            $offer->save();
            Storage::disk('public')->delete($oldFileName);
        }
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
        DB::select('select * from deleteRoomsByOfferId(?)', [$offer->id]);
        DB::select('select * from deleteOffer(?)', [$offer->id]);

        return redirect()->route('offers.my');
    }
}
