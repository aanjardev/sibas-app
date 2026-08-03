<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sibas.com'],
            [
                'name'      => 'Super Admin',
                'password'  => Hash::make('admin12345'),
                'role'      => 'admin',
                'no_hp'     => '081234567890',
                'alamat'    => 'Kantor Bank Sampah Pusat',
                'is_active' => true,
            ]
        );
    }
}
