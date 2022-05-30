<x-global>
    <div class="container mt-5 pt-4">
        <div class="d-flex col-12 justify-content-center">
            <img src="{{asset("storage/{$reservation->room->offer->image}")}}" class="img-fluid" style="max-height: 600px; margin: auto 0">
        </div>
        <h1 class="mt-4">{{ $reservation->room->name }}</h1>


        <h3 class="mt-5">Opis:</h3>
        <p>{{ $reservation->room->description }}</p>

        <h3 class="mt-5">Informacje:</h3>
        <p>Ilość łóżek: {{ $reservation->room->beds_amount }}</p>
        <p>Cena: {{$reservation->room->price}} zł/doba</p>

        <h3 class="mt-5">Oferta:</h3>
        <p>Rodzaj zakwaterowania: {{$reservation->room->offer->accommodationType}}</p>
        <p>Miejsce zakwaterowania: {{$reservation->room->offer->place}}</p>
        <p>Dodano przez: {{$reservation->room->offer->user->name}}</p>
        <p>Data dodania: {{$reservation->room->offer->created_at}}</p>

        <h3 class="mt-5">Zakwaterowanie:</h3>
        <p>Data: {{$reservation->date_from}} - {{$reservation->date_to}}</p>
        <p>Do zapłaty: {{$totalPrice}} zł</p>
    </div>
</x-global>
