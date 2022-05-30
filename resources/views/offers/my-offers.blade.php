<x-global>
    <div class="container">
        <div class="row gap-5 mt-3">
            <h1 class="col-12 text-center">Moje oferty</h1>
            <div class="d-flex gap-2 flex-column col-12 p-0">
                @foreach($offers as $offer)
                    @include('components.offer-card', ['offer' => $offer, 'canManage' => true])
                @endforeach
                <div class="d-flex justify-content-center">{{$offers->links()}}</div>
            </div>
        </div>
    </div>
</x-global>
