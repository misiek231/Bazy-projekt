<x-global>
    <div id="..." class="container mt-3 mb-5">
        <div class="mt-4 mb-4">
            <div class="row">
                <h1>Zarejestruj się</h1>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('register.store') }}">
            @csrf
            <div class="form-group mb-2">
                <label for="name">Imię</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}"
                class="@error('name') is-invalid @else is-valid @enderror">
            </div>
            <!-- Email Address -->
            <div class="form-group mb-2">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}"
                class="@error('email') is-invalid @else is-valid @enderror">
            </div>
            <div class="form-group mb-2">
                <label for="password">Hasło</label>
                <input id="password" name="password" type="password"
                    class="@error('password') is-invalid @else is-valid @enderror">
            </div>
            <div class="form-group mb-2">
                <label for="password_confirmation">Potwierdź hasło</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                    class="@error('password_confirmation') is-invalid @else is-valid @enderror">
            </div>

            <div class="form-group mb-2">

                <input id="offer-maker"
                       name="role_id"
                       type="radio"
                       value="2">

                <label for="offer-maker">Twórca ofert</label>

                <input id="offer-taker"
                       name="role_id"
                       type="radio"
                       value="3">

                <label for="offer-taker">Klient</label>
            </div>
            <div class="form-group mt-4">
                <input type="submit" value="Wyślij">
            </div>
        </form>
    </div>
</x-global>
