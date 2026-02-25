<?php

namespace Database\Seeders;

use App\Models\XeroCredential;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class XeroCredentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        XeroCredential::create([
             "client_id" => "3837341D60454B0793D18D2742F5E591",
            "client_secret" => "bj1rxI8Q-DBof_EibVC2_Y-MbiaXdF1O8lSm4iItLHo_vqqL"
         ]);
    }
}
