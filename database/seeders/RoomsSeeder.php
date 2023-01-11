<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('rooms')->count() !== 0) {
            return;
        }
        for ($i = 1; $i <= 5; $i++) {
            Room::create([
                'room_number' => '10' . $i
            ]);
        }
    }
}
