<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class SellerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Seller User',
            'email' => 'seller@example.com',
            'password' => bcrypt('password'),
            'role' => 'seller',
            'company_name' => 'Test Company',
            'phone' => '1234567890',
            'city' => 'Test City',
            'country' => 'Test Country',
            'verified' => true,
        ]);
    }
}