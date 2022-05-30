<x-global>

    <div class="container mt-5 pt-4">
        <div class="d-flex col-12 justify-content-center">
            <img src="{{asset("storage/{$room->offer->image}")}}" class="img-fluid" style="max-height: 600px; margin: auto 0">
        </div>
        <h1 class="mt-4">{{ $room->name }}</h1>


        <h3 class="mt-5">Opis:</h3>
        <p>{{ $room->description }}</p>

        <h3 class="mt-5">Informacje:</h3>
        <p>Ilość łóżek: {{ $room->beds_amount }}</p>
        <p>Cena: {{$room->price}} zł/doba</p>

        <h3 class="mt-5">Oferta:</h3>
        <p>Rodzaj zakwaterowania: {{$room->offer->accommodationType}}</p>
        <p>Miejsce zakwaterowania: {{$room->offer->place}}</p>
        <p>Dodano przez: {{$room->offer->user->name}}</p>
        <p>Data dodania: {{$room->offer->created_at}}</p>

            <form class="d-flex align-items-center flex-column" method="POST" action="{{route("reservations.store")}}">
                @csrf

                @can('is-offer-taker')
                    <h2>Dostępne terminy:</h2>
                @elsecan('is-offer-maker')
                    <h2>Terminy rezerwacji:</h2>
                @endcan

                <div id="app">
                    <calendar :disabled-dates="{{$disabledDates}}" :price="{{$room->price}}"></calendar>
                </div>

                <input name="date_from" type="hidden" id="date-from">
                <input name="date_to" type="hidden" id="date-to">
                <input name="room_id" type="hidden" value="{{$room->id}}">
                @can('is-offer-taker')
                    <button type="submit" class="btn btn-primary">Rezerwacja</button>
                @endcan
            </form>
    </div>
</x-global>
