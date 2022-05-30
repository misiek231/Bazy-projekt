<x-global>
    <div class="container mt-5 pt-5">
        <div class="row gap-1">
            <div class="card col-lg-3 col-sm-12 p-3" style="height: fit-content">
                <h3>Filtry</h3>
                @include("components.offers-filter-form")
            </div>
            <div class="d-flex gap-2 flex-column col-lg-8 col-sm-12 p-0">
                @foreach($offers as $offer)
                    @include('components.offer-card', ['offer' => $offer, 'canManage' => false])
                @endforeach
                <div class="d-flex justify-content-center">{{$offers->links()}}</div>
            </div>
        </div>
    </div>
</x-global>
