<x-global>
    <div class="mt-5 container">
        <h1 class="text-center">{{$offer->name}}</h1>
        <h1 class="text-center">{{$room->name}}</h1>

        <div id="app" class="d-flex justify-content-center mb-5">
            <calendar :disabled-dates="{{$disabledDates}}" :price="{{$room->price}}"></calendar>
        </div>

        <form class="row g-3 align-items-end" method="POST" action="{{route("reservations.store")}}">
            @csrf
            <input style="visibility: hidden" name="date_from" type="date" id="date-from">
            <input style="visibility: hidden" name="date_to" type="date" id="date-to">
            <input style="visibility: hidden" name="room_id" type="number" value="{{$room->id}}">
            <button type="submit" class="btn btn-primary">Dodaj rezerwację</button>
        </form>

        <script>
            window.onCalendarInput = function(date) {
                console.log(date);
                document.getElementById('date-from').value = date.start.toISOString().split('T')[0]
                document.getElementById('date-to').value = date.end.toISOString().split('T')[0]
            }
        </script>
    </div>

</x-global>
