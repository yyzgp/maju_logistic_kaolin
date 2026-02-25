<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merchants = Merchant::get()->pluck('id')->toArray();
        $services = [
            [
                "name"                  => "10FT DOLLY 100",
                "price"                 => 100,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "10FT DOLLY 110",
                "price"                 => 110,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "10FT DOLLY 120",
                "price"                 => 120,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "10FT TOW 60",
                "price"                 => 60,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "10FT TOW 70",
                "price"                 => 70,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "10FT TOW 80",
                "price"                 => 80,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "14FT TOW 100",
                "price"                 => 100,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "14FT TOW 80",
                "price"                 => 80,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "14FT TOW 90",
                "price"                 => 90,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Carpark (M/B) Conti Dolly(W) 120",
                "price"                 => 120,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Carpark (M/B) Conti Tow(W) 80",
                "price"                 => 80,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Carpark (Multi/Basement) Dolly Tow(W) 120",
                "price"                 => 120,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Carpark (Multi/Basement) Tow(W) 70",
                "price"                 => 70,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Accident Winch + Kingdolly Tow 145",
                "price"                 => 145,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Accident Winch + Standard Tow 105",
                "price"                 => 105,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Accident Winch Only 60",
                "price"                 => 60,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Change 1 New Tyre 50",
                "price"                 => 50,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Change 1 Tyre Valve 50",
                "price"                 => 50,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Change 2 Tyre(Using Tyre Machine) 60",
                "price"                 => 60,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Change 2 Tyre(Using Tyre Machine) 60",
                "price"                 => 60,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Change 3 Tyres (Using Tyre Machine) 70",
                "price"                 => 70,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Change 3 Tyres (Using Tyre Machine) 70",
                "price"                 => 70,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Change 4 Tyres (Using Tyre Machine) 80",
                "price"                 => 80,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Jumpstart Only 40",
                "price"                 => 40,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Kingdolly Tow 85",
                "price"                 => 85,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Kingdolly Tow (TP Compound) 115",
                "price"                 => 115,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Kingdolly Tow + Activate Charger 95",
                "price"                 => 95,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Kingdolly Tow + Change Battery 105",
                "price"                 => 105,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Kingdolly Tow + Patch 1 Tyre / Change 1 Tyre 105",
                "price"                 => 105,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Kingdolly Tow + Patch 2 Tyre / Change 2 Tyre 115",
                "price"                 => 115,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Kingdolly Tow + Patch 3 Tyre / Change 3 Tyre 125",
                "price"                 => 125,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Kingdolly Tow + Patch 4 Tyre / Change 4 Tyre 135",
                "price"                 => 135,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Kingdolly Tow + Unlock Door with Tools 95",
                "price"                 => 95,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Patch 1 tyre + Change 1 Tyre 60",
                "price"                 => 60,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Patch Tyre 40",
                "price"                 => 40,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Standard Tow 45",
                "price"                 => 45,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Standard Tow (TP Compound) 75",
                "price"                 => 75,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Standard Tow + Active Charge 55",
                "price"                 => 55,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Standard Tow + Active Charge 55",
                "price"                 => 55,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Standard Tow + Change 1 Battery 65",
                "price"                 => 65,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Standard Tow + Patch 1 Tyre 65",
                "price"                 => 65,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Standard Tow + Patch 2 Tyre/Change 2 Tyre 75",
                "price"                 => 75,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Standard Tow + Patch 3 Tires /Change 3 Tires 85",
                "price"                 => 85,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Standard Tow + Patch 4 Tires/Change 4 Tires 95",
                "price"                 => 95,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Standard Tow + Unlook Door with tools 55",
                "price"                 => 55,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Getgo Unlock Door With Tools 50",
                "price"                 => 50,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Kingdolly Tow 90",
                "price"                 => 100,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Kingdolly Tow Conti(W) 110",
                "price"                 => 110,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Kingdolly Tow(W) 100",
                "price"                 => 100,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Normal Tow Conti(W) 70",
                "price"                 => 70,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "PTE CAR B/M CARPARK KING DOLLY 110",
                "price"                 => 110,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "PTE CAR BASEMENT/MULTI CARPAR 70",
                "price"                 => 70,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "PTE CAR KING DOLLY 95",
                "price"                 => 95,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "PTE CAR NORMAL 55",
                "price"                 => 55,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "SAIL - 105D23L 190",
                "price"                 => 190,
                "merchants"             => json_encode($merchants),
                "status"                => true,
                "type"                  => ['Battery/Tyre']
            ],
            [
                "name"                  => "SAIL - 115D26L 210",
                "price"                 => 210,
                "merchants"             => json_encode($merchants),
                "status"                => true,
                "type"                  => ['Battery/Tyre']
            ],
            [
                "name"                  => "SAIL - 135D31L 220",
                "price"                 => 220,
                "merchants"             => json_encode($merchants),
                "status"                => true,
                "type"                  => ['Battery/Tyre']
            ],
            [
                "name"                  => "SAIL - 55B19L 140",
                "price"                 => 140,
                "merchants"             => json_encode($merchants),
                "status"                => true,
                "type"                  => ['Battery/Tyre']
            ],
            [
                "name"                  => "SAIL - 75B24L 150",
                "price"                 => 150,
                "merchants"             => json_encode($merchants),
                "status"                => true,
                "type"                  => ['Battery/Tyre']
            ],
            [
                "name"                  => "SPECIAL COMPOUND KINGDOLLY TOW 120",
                "price"                 => 120,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "SPECIAL COMPOUND STANDARD TOW 80",
                "price"                 => 80,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Standard Tow 50",
                "price"                 => 50,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Standard Tow(W) 60",
                "price"                 => 60,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Taxi Basement/Multi Carpark 65",
                "price"                 => 65,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "TAXI CANCELLATION FEE 30",
                "price"                 => 30,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "TAXI CHANGE SPARE TYRE 40",
                "price"                 => 40,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Taxi Crane Up Only 60",
                "price"                 => 60,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "TAXI FLATBED 105",
                "price"                 => 105,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "TAXI JUMPSTART 40",
                "price"                 => 40,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Taxi Kingdolly 90",
                "price"                 => 90,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "Taxi Normal 50",
                "price"                 => 50,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "TAXI STANDARD + CRANE UP 110",
                "price"                 => 110,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "VAN DOLLY 100",
                "price"                 => 100,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "VAN DOLLY 110",
                "price"                 => 110,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "VAN DOLLY 120",
                "price"                 => 120,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "VAN TOW 60",
                "price"                 => 60,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "VAN TOW 70",
                "price"                 => 70,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ],
            [
                "name"                  => "VAN TOW 80",
                "price"                 => 80,
                "merchants"             => json_encode($merchants),
                "extra_night_price"     => 10,
                "status"                => true,
                "type"                  => ['Towing', 'Battery/Tyre']
            ]
        ];

        foreach($services as $service){
            Service::create([
                "name"                  => $service["name"],
                "price"                 => $service["price"],
                "merchants"             => $merchants,
                "extra_night_price"     => 10,
                "status"                => $service["status"],
                "type"                  => $service["type"],
            ]);
        }
    }
}
