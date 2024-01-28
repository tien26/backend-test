<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = ['admin', 'user'];
        for ($i = 0; $i < count($email); $i++) {
            User::create([
                'email' => $email[$i] . '@gmail.com',
                'password' => bcrypt('12345678'),
                'roles' => $email[$i],
            ]);
        }
    }
}
