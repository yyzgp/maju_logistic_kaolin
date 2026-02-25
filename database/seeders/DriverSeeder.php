<?php

namespace Database\Seeders;

use App\Models\SingaporeLocation;
use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = app(Generator::class);

        $locations  = SingaporeLocation::orderBy('id', 'desc')->take(42)->get();

        $vehicleNames = [
            "Ford Transit",
            "Mercedes-Benz Sprinter",
            "Isuzu NPR",
            "Chevrolet Express",
            "Ram ProMaster",
            "Toyota Hiace",
            "Hino 268",
            "Kenworth T370",
            "Freightliner M2",
            "International MV",
            "Mitsubishi Fuso Canter",
            "Volvo VHD",
            "Peterbilt 337",
            "Nissan NV Cargo",
            "GMC Savana",
            "Hyundai H350",
            "Scania P-Series",
            "Tata Ultra T7",
            "Ashok Leyland Dost",
            "Mahindra Bolero Pik-Up"
          ];

          foreach($locations as $key => $location){

            $email = match($key){
              0 => 'driver@kaolin.com',
              1 => 'playstore@kaolin.com',
              2 =>  'appstore@kaolin.com',
              default => $faker->safeEmail()
            };

            User::factory()->create([
                'firstname'                     => $key == 0 ? "Marty" : $faker->firstname(),
                'lastname'                      => $key == 0 ? "Byrde" : $faker->lastname(),
                'email'                         =>  $email,
                'vehicle_type'                  => $faker->randomElement(['Car','Van', 'Truck', 'Bike', 'Bicycle', 'Walking']),
                'vehicle_description'           => $faker->randomElement($vehicleNames),
                'vehicle_registration_no'   => 'SNB'.$faker->numberBetween(1000, 9999).$faker->randomElement(['E', 'B', 'D', 'C']),
                "address" => $faker->randomElement([
                $faker->numberBetween(10, 20) .' '.$location->place.' '.$location->city.' '.ucfirst($location->area).' '.$faker->numberBetween(1, 10) . ' Gb Building',
                $faker->numberBetween(20, 30) .' '.$location->place.' '.$location->city.' '.ucfirst($location->area).' '.$faker->numberBetween(1, 10) . ' The Interlace',
                $faker->numberBetween(40, 50) .' '.$location->place.' '.$location->city.' '.ucfirst($location->area).' '.$faker->numberBetween(1, 10) . ' Golden Mile Complex',
                $faker->numberBetween(101, 201) .' '.$location->place.' '.$location->city.' '.ucfirst($location->area).' '.$faker->numberBetween(1, 10) . ' Raffles',
                $faker->numberBetween(203, 360) .' '.$location->place.' '.$location->city.' '.ucfirst($location->area).' '.$faker->numberBetween(1, 10) . ' Axa Tower',
                $faker->numberBetween(574, 699) .' '.$location->place.' '.$location->city.' '.ucfirst($location->area).' '.$faker->numberBetween(1, 10) . ' Sultan Plaza',

            ]),


            "latitude" => $location->latitude,
            "longitude" => $location->longitude,
            ]);
          }

          User::factory()->create([
            'firstname'                     => "Allen",
            'lastname'                      => "Walker",
            'email'                         => "allen@example.com",
            'vehicle_type'                  => $faker->randomElement(['Car', 'Van', 'Truck', 'Bike', 'Bicycle', 'Walking']),
            'vehicle_description'           => $faker->randomElement($vehicleNames),
            'vehicle_registration_no'       => 'SNB' . $faker->numberBetween(1000, 9999) . $faker->randomElement(['E', 'B', 'D', 'C']),
            'password'                      => Hash::make('allen123456'),
            "address"                       => $faker->randomElement([
              $faker->numberBetween(10, 20) . ' ' . $location->place . ' ' . $location->city . ' ' . ucfirst($location->area) . ' ' . $faker->numberBetween(1, 10) . ' Gb Building',
              $faker->numberBetween(20, 30) . ' ' . $location->place . ' ' . $location->city . ' ' . ucfirst($location->area) . ' ' . $faker->numberBetween(1, 10) . ' The Interlace',
              $faker->numberBetween(40, 50) . ' ' . $location->place . ' ' . $location->city . ' ' . ucfirst($location->area) . ' ' . $faker->numberBetween(1, 10) . ' Golden Mile Complex',
              $faker->numberBetween(101, 201) . ' ' . $location->place . ' ' . $location->city . ' ' . ucfirst($location->area) . ' ' . $faker->numberBetween(1, 10) . ' Raffles',
              $faker->numberBetween(203, 360) . ' ' . $location->place . ' ' . $location->city . ' ' . ucfirst($location->area) . ' ' . $faker->numberBetween(1, 10) . ' Axa Tower',
              $faker->numberBetween(574, 699) . ' ' . $location->place . ' ' . $location->city . ' ' . ucfirst($location->area) . ' ' . $faker->numberBetween(1, 10) . ' Sultan Plaza',

            ]),
            "latitude" => $location->latitude,
            "longitude" => $location->longitude,
          ]);


    }
}
