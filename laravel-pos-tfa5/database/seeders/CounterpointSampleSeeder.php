<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CounterpointSampleSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['full_name' => 'Amara Santos', 'email' => 'amara.santos@example.com', 'phone' => '+63 917 482 6301'],
            ['full_name' => 'Leo Navarro', 'email' => 'leo.navarro@example.com', 'phone' => '+63 918 735 2046'],
            ['full_name' => 'Mira Delgado', 'email' => 'mira.delgado@example.com', 'phone' => '+63 905 661 2984'],
            ['full_name' => 'Nico Reyes', 'email' => 'nico.reyes@example.com', 'phone' => '+63 922 147 8503'],
            ['full_name' => 'Tala Mendoza', 'email' => 'tala.mendoza@example.com', 'phone' => '+63 916 904 7128'],
        ] as $customer) {
            Customer::updateOrCreate(['email' => $customer['email']], $customer);
        }

        foreach ([
            ['username' => 'aramos', 'full_name' => 'Avery Ramos'],
            ['username' => 'bcruz', 'full_name' => 'Bianca Cruz'],
            ['username' => 'dlim', 'full_name' => 'Dylan Lim'],
            ['username' => 'esalazar', 'full_name' => 'Elena Salazar'],
            ['username' => 'jvaldez', 'full_name' => 'Joaquin Valdez'],
        ] as $user) {
            User::updateOrCreate(['username' => $user['username']], $user);
        }
    }
}
