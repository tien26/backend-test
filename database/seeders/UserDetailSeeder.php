<?php

namespace Database\Seeders;

use App\Models\UserDetail;
use Illuminate\Database\Seeder;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 5; $i++) {
            UserDetail::create([
                'user_id' => $i,
                'name' => 'lorem user-' . $i,
                'phone' => '081293891283',
                'sim' => '012-01290-81' . $i,
                'photo' => 'photo',
            ]);
        }
    }
}
