<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\MerchantBillingDetail;
use App\Models\MerchantStoreDetail;
use App\Models\SingaporeLocation;
use Faker\Generator;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker      = app(Generator::class);
        $locations  = SingaporeLocation::orderBy('id', 'desc')->take(41)->get();

        $merchants = [
            'ACROSS ASIA ASSIST (S) PTE. LTD.',
            'LUMENS PTE. LTD.',
            'SPARK CREDIT PTE. LTD',
            'ALL MOTORING',
            'ALLIANCE LEASING PTE LTD',
            'ALLSWELL LEASING & LIMOUSINE PTE LTD',
            'ANN AUTOMOTIVE',
            'AUTO EXCEL ENGINEERING PTE LTD',
            'B K W RENT A CAR PTE LTD',
            'CAR TIMES AUTOMOBILE PTE LTD',
            'CHUANG LI PARTNERS PTE LTD',
            'CITY AUTO PTE LTD',
            'CLEANHUB FACILITY PTE LTD',
            'COMFORTDELGRO ENGINEERING PTE LTD',
            'DING AUTO (CARROS)',
            'DING AUTO (SIN MING)',
            'FOCUS RENTALS PTE LTD',
            'GETGO TECHNOLOGIES PTE. LTD.',
            'GOLDBELL CAR RENTAL PTE LTD',
            'GOODFELLAS AUTO SERVICE CENTRE PTE LTD',
            'JA8 SCRAP',
            'KAOLIN CAR TRADING PTE LTD',
            'kelly',
            'KINTO SINGAPORE PTE LTD',
            'LAI HUAT (MENG KEE) MOTOR PTE LTD',
            'Mah Lian Motor Vehicle Repairer',
            'MY CAR CONSULTANT PTE. LTD.',
            'NET LINK PARTNERS PTE. LTD.',
            'OSCAR LOGISTIC PTE LTD',
            'PAYNOW',
            'PRIME MOTOR & LEASING PTE. LTD.',
            'RICARDO AUTO CENTRE PTE LTD',
            'SHIFU AUTOMOBILE',
            'SJ MOTOR ENTERPRISE',
            'SOON XING AUTO',
            'SPARK MOTORING PTE LTD',
            'ST ENGINEERING PTE LTD',
            'ST RENT AND DRIVE PTE. LTD.',
            'TOH MOTOR ENTERPRISE',
            'TWIN WHEELS AUTO TRADING ENTERPRISE',
            'VTECH AUTO'
        ];

        foreach ($locations as $key => $location) {

            $merchant = Merchant::create([
                'name'              => $merchants[$key],
                'email'             => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'avatar'            => null,
                'password'          => Hash::make('password'),
                'status'            => 'active',
                'remember_token'    => Str::random(10),
            ]);

            $store = MerchantStoreDetail::create([
                'merchant_id' => $merchant->id,
                'name'        => $faker->firstname() . ' ' . $faker->lastname(),
                'email'       => $faker->unique()->safeEmail(),
                'dialcode'    => "+65",
                'phone'       => $faker->numerify('8#7##70#'),
                'address'     => $faker->randomElement([

                    $faker->numberBetween(10, 20) .' '.$location->place.' '.$location->city.' '.$location->area.' '.$faker->numberBetween(1, 10) . ' Gb Building',
                    $faker->numberBetween(20, 30) .' '.$location->place.' '.$location->city.' '.$location->area.' '.$faker->numberBetween(1, 10) . ' The Interlace',
                    $faker->numberBetween(40, 50) .' '.$location->place.' '.$location->city.' '.$location->area.' '.$faker->numberBetween(1, 10) . ' Golden Mile Complex',
                    $faker->numberBetween(101, 201) .' '.$location->place.' '.$location->city.' '.$location->area.' '.$faker->numberBetween(1, 10) . ' Raffles',
                    $faker->numberBetween(203, 360) .' '.$location->place.' '.$location->city.' '.$location->area.' '.$faker->numberBetween(1, 10) . ' Axa Tower',
                    $faker->numberBetween(574, 699) .' '.$location->place.' '.$location->city.' '.$location->area.' '.$faker->numberBetween(1, 10) . ' Sultan Plaza',

                ]),
                'building_floor_room' => $faker->numberBetween(1, 28) . ', ' . $faker->randomElement(['1st Floor', '2nd Floor', '3rd Floor', '4th Floor', '5th Floor']),


                "latitude" => $location->latitude,
                "longitude" => $location->longitude,

                'notes'               => 'At ' . $merchants[$key] . ' we are committed to delivering top-notch automotive repair services to keep your vehicle running smoothly. Our experienced and certified technicians provide reliable, high-quality repairs and maintenance for all makes and models. From routine oil changes and brake services to more complex engine diagnostics and transmission repairs, we offer a comprehensive range of services tailored to your car’s needs.',
                'iso2'                => 'sg'
            ]);

            $billing = MerchantBillingDetail::create([
                'merchant_id' => $merchant->id,
                'name'        => $faker->firstname() . ' ' . $faker->lastname(),
                'email'       => $faker->unique()->safeEmail(),
                'dialcode'    => "+65",
                'phone'       => $faker->numerify('8#7##70#'),
                'address'     => $faker->randomElement([

                    $faker->numberBetween(100, 999) . ' Bedok North Avenue #' . $faker->numberBetween(1, 10) . ' Gb Building',
                    $faker->numberBetween(100, 758) . ' Jalan Sultan ' . $faker->numberBetween(1, 10) . ' Sultan Plaza',
                    $faker->numberBetween(100, 877) . ' Eunos Avenue 7A 01-08',
                    $faker->numberBetween(1, 10) . ' Mornington Crescent',
                    $faker->numberBetween(100, 575) . ' East Coast Road 09 Peninsula Plaza',
                    $faker->numberBetween(100, 545) . ' Jurong East Street 21 ,' . $faker->numberBetween(1, 10) . ' Imm Bldg'

                ]),
                "latitude" => $location->latitude,
                "longitude" => $location->longitude,
                'iso2'               => 'sg'
            ]);
        }
    }
}
