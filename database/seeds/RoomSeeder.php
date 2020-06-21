<?php

use App\Room;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Generator;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param Generator $faker
     * @return void
     */
    public function run(Generator $faker)
    {
        DB::table('rooms')->insert([
            'code' => $faker->randomNumber(6),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'status' => Room::ROOM_STATUS_JOINING
        ]);
    }
}
