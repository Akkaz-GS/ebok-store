<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@ebook.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Penjual Demo',
            'email'    => 'penjual@ebook.com',
            'password' => Hash::make('password'),
            'role'     => 'penjual',
        ]);

        User::create([
            'name'     => 'Pembeli Demo',
            'email'    => 'pembeli@ebook.com',
            'password' => Hash::make('password'),
            'role'     => 'pembeli',
        ]);
    }
}