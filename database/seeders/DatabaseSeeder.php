<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call([
        //     RolesSeeder::class,
        //     UserSeeder::class,
        //     OfferSeeder::class,
        //     RoomSeeder::class,
        //     ReservationSeeder::class
        // ]);

        DB::select('call seed_data()');
    }
}
