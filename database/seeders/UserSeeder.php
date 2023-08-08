<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = DB::table('users')
            ->where('email', 'admin1@mail.com')
            ->first();

        if (null === $admin) {
            DB::table('users')->insert([
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'superadmin@admin.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
