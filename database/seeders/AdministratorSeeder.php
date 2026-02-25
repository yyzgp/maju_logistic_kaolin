<?php

namespace Database\Seeders;

use App\Models\Administrator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Administrator::factory()->create([
            'firstname' => 'Nurul',
            'lastname'  => 'Hasan',
            'email'     => 'admin@kaolin.com',
            'role'      => 'superadmin'
        ]);

        Administrator::factory()->create([
            'firstname' => 'Sohrab',
            'lastname'  => 'Khan',
            'email'     => 'dispatcher@kaolin.com',
        ]);

        Administrator::factory()->create([
            'firstname' => 'John',
            'lastname'  => 'Wick',
            'email'     => 'john@kaolin.com',
            'password'  => Hash::make('john123456')
        ]);

        Administrator::factory(18)->create();
    }
}
