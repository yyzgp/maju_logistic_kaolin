<?php

namespace Database\Seeders;

use App\Models\VehicleType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleType::create([
            'name' => 'Car',
        ]);
        VehicleType::create([
            'name' => 'Van',
        ]);
        VehicleType::create([
            'name' => 'Truck',
        ]);
        VehicleType::create([
            'name' => 'Bus',
        ]);
        VehicleType::create([
            'name' => 'Bike',
        ]);
    }
}
