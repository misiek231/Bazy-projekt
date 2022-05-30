<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('roles')->truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();
        DB::table('roles')->upsert(
            [
                [
                    'name' => 'admin',
                ],
                [
                    'name' => 'ofr_maker'
                ],
                [
                    'name' => 'ofr_taker'
                ],
            ],
            'name'
        );
    }
}
