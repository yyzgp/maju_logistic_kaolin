<?php

namespace Database\Seeders;

use App\Models\DeliveryOrder;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $start_date = '2025-01-01';
        $end_date = '2030-01-31';


        $period = new DatePeriod(
            new DateTime($start_date),
            new DateInterval('P1D'),
            new DateTime($end_date . ' +1 day')
        );

        foreach ($period as $date) {
            DeliveryOrder::create([
                'delivery_date' => $date->format('Y-m-d'),
            ]);

        }

    }
}
