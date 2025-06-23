<?php

namespace Database\Seeders;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => '1',
            'name' => 'Admin Village',
            'email' => 'admin@gmail.com',
            'password' => 'password',
            'status' => 'approved',
            'role_id' => '1',
        ]);
        User::create([
            'id' => '2',
            'name' => 'Resident 1',
            'email' => 'resident1@gmail.com',
            'password' => 'password',
            'status' => 'approved',
            'role_id' => '2',
        ]);

        Resident::create([
            'user_id' => '2',
            'nik' => '6767676767676767',
            'name' => 'Adam',
            'gender' => 'male',
            'birth_date' => '2000-01-01',
            'birth_place' => 'Jakarta',
            'address' => 'Bandung',
            'marital_status' => 'single',
        ]);
    }
}
