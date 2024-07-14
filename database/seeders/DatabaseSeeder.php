<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@dev.com',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'group_user' => 1,
            'alamat' => 'Bandung',
            'kode_pos' => '40535',
            'kelurahan' => 'cibereum',
            'kecamatan' => 'Cimahi Selatan',
            'kota' => 'Cimahi',
            'provinsi' => 'Jawa Barat',
            'no_hp' => '081224580918',
        ]);
    }
}
