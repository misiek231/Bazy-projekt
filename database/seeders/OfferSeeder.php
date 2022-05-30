<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        Room::truncate();
        Offer::truncate();
        Schema::enableForeignKeyConstraints();
        //Offer::factory(50)->create();

        Offer::upsert(
            [
                [
                    'name' => 'Domki u basi',
                    'description' => 'Wspaniałe domki u basi. Zapewione są wszystkie wymagane opcje, które każdy z naszych klientów wymaga. Duże łóźka, wygodne łazienki. Świetna lokalizacja na wypad rodzinny.',
                    'image' => '(1).jpg',
                    'place' => "Kraków",
                    'accommodationType' => 'Pensjonat',
                    'user_id' => 2,
                ],
                [
                    'name' => 'Domek nad jeziorem',
                    'description' => 'Niesamowity domek nad jeziorem. Super widok z każdego balkonu. Do okoła znajduje się wiele szlaków turystycznych oraz zabytków. Pełne wyposażenie.',
                    'image' => '(2).jpg',
                    'place' => "Zakopane",
                    'accommodationType' => 'Kwatera prywata',
                    'user_id' => 2,
                ]
            ],
            'name'
        );
    }
}
