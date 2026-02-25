<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use App\Models\SingaporeLocation;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SingaporeLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker      = app(Generator::class);
        GeneralSetting::create([
            "type" => "invoice_frequency",
            "value" => "weekly",
        ]);

        $csvFile = fopen(base_path("database/data/locations.csv"), "r");

        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline && !empty($data['1'])) {

                SingaporeLocation::create([
                    'place'                     => $data['0'] ? $data['0'] : null,
                    'city'                      => $data['1'] ? $data['1'] : null,
                    'area'                      => $data['2'] ? $data['2'] : null,
                    'latitude'                  => $data['3'] ? $data['3'] : null,
                    'longitude'                 => $data['4'] ? $data['4'] : null,
                    'bounding_box_1'            => $data['5'] ? $data['5'] : null,
                    'bounding_box_2'            => $data['6'] ? $data['6'] : null,
                    'bounding_box_3'            => $data['7'] ? $data['7'] : null,
                    'bounding_box_4'            => $data['8'] ? $data['8'] : null
                ]);
            }
            $firstline = false;
        }

        fclose($csvFile);

    }
}
