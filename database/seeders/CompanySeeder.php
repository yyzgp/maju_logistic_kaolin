<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanySetting::create([
            'company'           => 'Logistics Car Trading Pte Ltd',
            'email'             => 'kaolincar@gmail.com',
            'dialcode'          => '+65',
            'phone'             => '88009091',
            'address_line_1'    => '61 Woodlands Ind Park',
            'address_line_2'    => 'E9 #04-19 Singapore ',
            'city'              => 'Payalebar',
            'zipcode'           => '757047',
            'state'             => 'East Region',
            'iso2'              => 'sg',
            'website'           => 'https://kaolin-towing.com/',
            'uen_no'            => '201730867M',
            'gst_no'            => '201730867M',
            'bank_name'         => 'OCBC',
            'bank_account_no'   => '712452515001',
            'cheque_payable_to' => 'KAOLIN LOGISTIC PTE LTD',
            'logo'              => Null,
        ]);
    }
}
