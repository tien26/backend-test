<?php

namespace Database\Seeders;

use App\Models\CarList;
use Illuminate\Database\Seeder;

class CarListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 15; $i++) {
            CarList::create([
                'merk' => 'lorem ipsum' . $i,
                'model' => 'lorem-' . $i,
                'no_car' => 'B 1010 B' . $i,
                'price' => 5000,
                'photo' => null,
                'status' => false,
            ]);
        }
    }
}
