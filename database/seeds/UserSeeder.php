<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = [
            'raj',
            'shanu',
            'deepa',
            'sheu',
        ];

        forEach($names as $name) {
            DB::table('users')->insert([
                'name' => $name,
                'email' => "$name@dp.com",
                'password' => Hash::make('11111111'),
            ]);
        }
    }
}
