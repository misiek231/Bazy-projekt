<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
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
        User::truncate();
        Schema::enableForeignKeyConstraints();
        //User::factory(10)->create();

        User::upsert(
            [
                [
                    'name' => 'Admin',
                    'email' => 'admin@sleepy.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('123'),
                    'remember_token' => Str::random(10),
                    'role_id' => 1,
                ],
                [
                    'name' => 'Oferty',
                    'email' => 'oferty@sleepy.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('123'),
                    'remember_token' => Str::random(10),
                    'role_id' => 2,
                ],
                [
                    'name' => 'Rezerwacje',
                    'email' => 'rezerwacje@sleepy.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('123'),
                    'remember_token' => Str::random(10),
                    'role_id' => 3,
                ],
            ],
            'name'
        );
    }
}
