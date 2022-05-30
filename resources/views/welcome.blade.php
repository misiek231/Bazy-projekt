<x-global>



    <div class="img-text-container">
        <img src="{{ asset('img/banner.jpg') }}" alt="banner">
        <p class="centered-img-text">Znajdź swoje miejsce</p>
    </div>

    <div class="container d-flex justify-content-center flex-column">
        <div>
            <h1 class="text-center p-5">Wyszukaj swoje wymarzone miejsce na nocleg</h1>
        </div>

        @include("components.offers-filter-form")
    </div>
</x-global>
