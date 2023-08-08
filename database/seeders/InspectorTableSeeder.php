<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class InspectorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = DB::table('inspectors')
            ->where('email', 'zoer@mail.com')
            ->first();

        if (null === $admin) {
            DB::table('inspectors')->insert([
                'first_name' => 'Admin1',
                'last_name' => 'Admin2',
                'email' => 'zoer@mail.com',
                'status' => 'true',
                'region_id' => 1,
                'password' => Hash::make('111111'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
