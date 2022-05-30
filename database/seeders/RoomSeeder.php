<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RoomSeeder extends Seeder
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
        Schema::enableForeignKeyConstraints();
        // Room::factory(500)->create();

        Room::upsert(
            [
                [
                    'name' => 'Pokój dla dziecka',
                    'description' => 'Pokój dla dziecka, dużo zabawek oraz komputerów',
                    'price' => 200,
                    'beds_amount' => 1,
                    'offer_id' => 1,
                ],
                [
                    'name' => 'Pokój dla rodziców',
                    'description' => 'Pokój dla rodziców, duże łózko oraz prywatna łaziekna. Blkon z widokiem na miasto.',
                    'price' => 250,
                    'beds_amount' => 2,
                    'offer_id' => 1,
                ],
                [
                    'name' => 'Mirabelka',
                    'description' => 'Pokój mirabelka to świetna propozycja dla każdego turysty pragnącego odpocząć od pracy. Do okoła panuje cisza i spokój.',
                    'price' => 400,
                    'beds_amount' => 1,
                    'offer_id' => 2,
                ]

            ],
            'name'
        );
    }
}
