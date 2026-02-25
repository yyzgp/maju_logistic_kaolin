<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class AdministratorFactory extends Factory
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
        return [
            'firstname'         => fake()->firstname(),
            'lastname'          => fake()->lastname(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'dialcode'          => '+65',
            'phone'             => fake()->numerify('6#######'),
            'gender'            => 'Male',
            'address'           => fake()->randomElement([

                    fake()->numberBetween(100, 999).' Bedok North Avenue #'.fake()->numberBetween(1, 10).' Gb Building',
                    fake()->numberBetween(100, 758).' Jalan Sultan '.fake()->numberBetween(1, 10).' Sultan Plaza',
                    fake()->numberBetween(100, 877).' Eunos Avenue 7A 01-08', fake()->numberBetween(1, 10).' Mornington Crescent',
                    fake()->numberBetween(100, 575).' East Coast Road 09 Peninsula Plaza',
                    fake()->numberBetween(100, 545).' Jurong East Street 21 ,'.fake()->numberBetween(1, 10).' Imm Bldg'

                ]),
            'city'              => fake()->randomElement(['Tampines', 'Pasir Ris', 'Bukit Merah', 'Kallang', 'Payalebar', 'Tyersall', 'Sentosa']),
            'zipcode'           => fake()->randomElement(['229921', '388365', '069542', '508988', '609601', '179098']),
            'state'             => fake()->randomElement(['Central Region', 'North Region', 'Northeast Region', 'East Region', 'West Region']),
            'iso2'              => 'sg',
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
