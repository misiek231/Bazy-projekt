<form class="row g-3 align-items-end" method="get" action="{{route("offers.index")}}">
    <div class="col-12">
        <label for="name" class="form-label">Nazwa</label>
        <input name="name" type="text" class="form-control" id="name" placeholder="Borkowska">
    </div>
    <div class="col-md-6">
        <label for="dateFrom" class="form-label">Data od</label>
        <input name="dateFrom" type="date" class="form-control" id="dateFrom">
    </div>
    <div class="col-md-6">
        <label for="dateTo" class="form-label">Data do</label>
        <input name="dateTo" type="date" class="form-control" id="dateTo">
    </div>
    <div class="col-12">
        <label for="place" class="form-label">Miejsce</label>
        <input name="place" type="text" class="form-control" id="place" placeholder="Kraków">
    </div>
    <div class="col-md-6">
        <label for="peopleAmount" class="form-label">Ilość osób</label>
        <input name="peopleAmount" type="number" class="form-control" id="peopleAmount">
    </div>
    <div class="col-6">
        <label for="accommodationType" class="form-label">Rodzaj zakwaterowania</label>
        <input name="accommodationType" type="text" class="form-control" id="accommodationType" placeholder="Pensjonat">
    </div>
    <div class="col-md-6">
        <label for="priceFrom" class="form-label">Cena od</label>
        <input name="priceFrom" type="number" class="form-control" id="priceFrom">
    </div>
    <div class="col-md-6">
        <label for="priceTo" class="form-label">Cena do</label>
        <input name="priceTo" type="number" class="form-control" id="priceTo">
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Szukaj</button>
    </div>
</form>
