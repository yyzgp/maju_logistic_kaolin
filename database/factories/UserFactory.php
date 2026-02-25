<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
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
        return [
            'firstname'         => fake()->firstname(),
            'lastname'          => fake()->lastname(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'dialcode'          => '+65',
            'phone'             => fake()->numerify('6#########'),
            'gender'            => fake()->randomElement(['Male', 'Female']),
            'address'           => fake()->buildingNumber . ', ' . 'Paya Lebar Rd #03-07, Orion@Payalebar',
            'city'              => fake()->randomElement(['Hougang', 'Tampines', 'Clementi', 'Yushun', 'Woodlands', 'Seletar']),
            'state'             => fake()->randomElement(['Central Region', 'East Region', 'North Region', 'North-East Region', 'West Region']),
            'zipcode'           => fake()->randomElement(['40901', '40902', '40903']),
            'iso2'              => 'sg',
            'status'            => true,
            'password'          => static::$password ??= Hash::make('password'),
            'vehicle_type'                  => fake()->randomElement(['Car','Van', 'Truck', 'Bike', 'Bicycle', 'Walking']),
            'vehicle_description'           => fake()->randomElement($vehicleNames),
            'vehicle_registration_no'   => 'SNB'.fake()->numberBetween(1000, 9999).fake()->randomElement(['E', 'B', 'D', 'C']),
            'remember_token'    => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
