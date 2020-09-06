<?php

use App\Room;
use App\User;
use Faker\Generator;
use Illuminate\Database\Seeder;

class RoomUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param Generator $faker
     * @return void
     */
    public function run(Generator $faker)
    {
        $room = Room::first();
        $users = User::limit(4)->get();
        $users->map(function ($user, $index) use ($room) {
            $room->users()->attach($user->id, ['position' => Room::ALL_POSITIONS[$index]]);
        });
    }
}
