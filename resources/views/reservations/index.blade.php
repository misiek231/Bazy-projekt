<x-global>
    <div class="container mt-3">
        <h1 class="text-center">Moje rezerwacje</h1>
        <div class="row mt-5">
            <div class="d-flex gap-2 flex-column col-12 p-0">
                @foreach($reservations as $reservation)
                    <a href="{{route("reservations.show", $reservation->id)}}" style="text-decoration: none; color: inherit">
                        <div class="card mb-3">
                            <img src="{{asset("storage/{$reservation->room->offer->image}")}}" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">{{ $reservation->room->name }}</h5>
                                <p class="card-text">{{ $reservation->room->description }}</p>
                                <p class="card-text"><small class="text-muted">Data: {{ $reservation->date_from }} - {{ $reservation->date_to }}</small></p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-global>
