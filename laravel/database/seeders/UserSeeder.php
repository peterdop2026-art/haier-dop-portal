<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            ['sap_id' => 'SAP0001', 'password' => Hash::make('password')]
        );
    }
}
