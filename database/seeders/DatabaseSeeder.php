<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('positions')->insert([
            ['name' => 'Boshliq'],
            ['name' => 'Ish boshqaruvchi'],
            ['name' => 'Ishchi'],
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@mail.ru',
            'password' => Hash::make('123456'),
        ]);
		
		DB::table('staffs')->insert([
            'user_id' => '1',
            'position_id' => '1',
        ]);
		
        DB::table('car_comfort_class')->insert([
            ['name' => 'start'],
            ['name' => 'comfort'],
            ['name' => 'biznes'],
        ]);

        DB::table('usr_categ_and_cars')->insert([
            ['position_id' => 1, 'car_comfort_class_id' => 3],
            ['position_id' => 1, 'car_comfort_class_id' => 2],
            ['position_id' => 1, 'car_comfort_class_id' => 1],
            ['position_id' => 2, 'car_comfort_class_id' => 2],
            ['position_id' => 2, 'car_comfort_class_id' => 1],
            ['position_id' => 3, 'car_comfort_class_id' => 1],
        ]);

        DB::table('drivers')->insert([
            'name' => 'Admin',
            'phone' => '998901234567',
        ]);

        DB::table('cars')->insert([
            ['model' => 'Damas', 'car_comfort_class_id' => 1, 'driver_id' => 1],
            ['model' => 'Matiz', 'car_comfort_class_id' => 1, 'driver_id' => 1],
            ['model' => 'Spark', 'car_comfort_class_id' => 1, 'driver_id' => 1],
            ['model' => 'Cobalt', 'car_comfort_class_id' => 2, 'driver_id' => 1],
            ['model' => 'Gentra', 'car_comfort_class_id' => 2, 'driver_id' => 1],
            ['model' => 'Malibu', 'car_comfort_class_id' => 3, 'driver_id' => 1],
            ['model' => 'Tracker 2', 'car_comfort_class_id' => 3, 'driver_id' => 1],
        ]);
    }
}
