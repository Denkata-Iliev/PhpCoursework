<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'DefaultAdmin',
            'email' => 'admin@admin.com',
            'password' => '$2a$12$hQCvlxXzW33E2XakIordluMYDu9uCP8bRCpAGvzjZqaSG2CPD4tLO'
        ])->assignRole('ADMIN');
    }
}
