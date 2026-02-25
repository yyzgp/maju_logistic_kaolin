<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\MerchantXeroCredential;
use Dcblogdev\Xero\Facades\Xero;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MerchantXeroCredentialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {


        DB::table('merchant_xero_credentials')->delete();

        DB::table('merchant_xero_credentials')->insert(array (
            0 =>
            array (
                'id' => 1,
                'merchant_id' => 1,
                'contact_id' => '26313988-bc25-4a77-a2bb-fec4e2eab382',
                'contact_number' => 1,
                'created_at' => '2025-01-24 17:40:04',
                'updated_at' => '2025-01-24 17:40:04',
            ),
            1 =>
            array (
                'id' => 2,
                'merchant_id' => 2,
                'contact_id' => '7956f71a-dc03-4502-bcdc-58f9082aaae6',
                'contact_number' => 2,
                'created_at' => '2025-01-24 17:40:05',
                'updated_at' => '2025-01-24 17:40:05',
            ),
            2 =>
            array (
                'id' => 3,
                'merchant_id' => 3,
                'contact_id' => '2814ced9-b786-4772-9faf-8016d2c447fb',
                'contact_number' => 3,
                'created_at' => '2025-01-24 17:40:06',
                'updated_at' => '2025-01-24 17:40:06',
            ),
            3 =>
            array (
                'id' => 4,
                'merchant_id' => 4,
                'contact_id' => '77bfe284-6c57-4540-bd50-765af3461647',
                'contact_number' => 4,
                'created_at' => '2025-01-24 17:40:06',
                'updated_at' => '2025-01-24 17:40:06',
            ),
            4 =>
            array (
                'id' => 5,
                'merchant_id' => 5,
                'contact_id' => 'abb37e89-f2f4-4b66-ae04-6cfa32e187bd',
                'contact_number' => 5,
                'created_at' => '2025-01-24 17:40:07',
                'updated_at' => '2025-01-24 17:40:07',
            ),
            5 =>
            array (
                'id' => 6,
                'merchant_id' => 6,
                'contact_id' => '738a25f5-4692-422a-95cc-f054a0d0cd3c',
                'contact_number' => 6,
                'created_at' => '2025-01-24 17:40:08',
                'updated_at' => '2025-01-24 17:40:08',
            ),
            6 =>
            array (
                'id' => 7,
                'merchant_id' => 7,
                'contact_id' => 'a1aaf8a7-0d35-4316-aa33-443051ca4723',
                'contact_number' => 7,
                'created_at' => '2025-01-24 17:40:08',
                'updated_at' => '2025-01-24 17:40:08',
            ),
            7 =>
            array (
                'id' => 8,
                'merchant_id' => 8,
                'contact_id' => '14a61405-3859-4976-bd09-4eab189a05ee',
                'contact_number' => 8,
                'created_at' => '2025-01-24 17:40:09',
                'updated_at' => '2025-01-24 17:40:09',
            ),
            8 =>
            array (
                'id' => 9,
                'merchant_id' => 9,
                'contact_id' => '9ccad7fa-3961-4068-9fa9-36e8c0f278af',
                'contact_number' => 9,
                'created_at' => '2025-01-24 17:40:09',
                'updated_at' => '2025-01-24 17:40:09',
            ),
            9 =>
            array (
                'id' => 10,
                'merchant_id' => 10,
                'contact_id' => '81fc961f-7a0c-41cc-a2b4-f8831b9a4d03',
                'contact_number' => 10,
                'created_at' => '2025-01-24 17:40:09',
                'updated_at' => '2025-01-24 17:40:09',
            ),
            10 =>
            array (
                'id' => 11,
                'merchant_id' => 11,
                'contact_id' => 'b0dbe470-e553-4a3d-b76c-73602db6b10f',
                'contact_number' => 11,
                'created_at' => '2025-01-24 17:40:10',
                'updated_at' => '2025-01-24 17:40:10',
            ),
            11 =>
            array (
                'id' => 12,
                'merchant_id' => 12,
                'contact_id' => '2c1f6df5-55ef-4b64-8020-acce46697c3e',
                'contact_number' => 12,
                'created_at' => '2025-01-24 17:40:10',
                'updated_at' => '2025-01-24 17:40:10',
            ),
            12 =>
            array (
                'id' => 13,
                'merchant_id' => 13,
                'contact_id' => '306af27d-9d4e-4bd4-b5b3-d2def2126bcb',
                'contact_number' => 13,
                'created_at' => '2025-01-24 17:40:11',
                'updated_at' => '2025-01-24 17:40:11',
            ),
            13 =>
            array (
                'id' => 14,
                'merchant_id' => 14,
                'contact_id' => '5f37a985-044a-4ae2-b43f-d53460239c3e',
                'contact_number' => 14,
                'created_at' => '2025-01-24 17:40:11',
                'updated_at' => '2025-01-24 17:40:11',
            ),
            14 =>
            array (
                'id' => 15,
                'merchant_id' => 15,
                'contact_id' => '0ba74e67-dac9-4618-8a73-00066f6065be',
                'contact_number' => 15,
                'created_at' => '2025-01-24 17:40:12',
                'updated_at' => '2025-01-24 17:40:12',
            ),
            15 =>
            array (
                'id' => 16,
                'merchant_id' => 16,
                'contact_id' => 'a172142c-b6da-425a-bcad-29d7bf821a9f',
                'contact_number' => 16,
                'created_at' => '2025-01-24 17:40:12',
                'updated_at' => '2025-01-24 17:40:12',
            ),
            16 =>
            array (
                'id' => 17,
                'merchant_id' => 17,
                'contact_id' => 'b153578c-7b20-4481-9107-d57eee8ef995',
                'contact_number' => 17,
                'created_at' => '2025-01-24 17:40:13',
                'updated_at' => '2025-01-24 17:40:13',
            ),
            17 =>
            array (
                'id' => 18,
                'merchant_id' => 18,
                'contact_id' => 'f3294850-109e-4925-92bb-9c98329958ec',
                'contact_number' => 18,
                'created_at' => '2025-01-24 17:40:13',
                'updated_at' => '2025-01-24 17:40:13',
            ),
            18 =>
            array (
                'id' => 19,
                'merchant_id' => 19,
                'contact_id' => 'a3ab1026-58ab-4697-8bca-a53a2af7a6a2',
                'contact_number' => 19,
                'created_at' => '2025-01-24 17:40:14',
                'updated_at' => '2025-01-24 17:40:14',
            ),
            19 =>
            array (
                'id' => 20,
                'merchant_id' => 20,
                'contact_id' => 'f389036d-a9d1-4153-b127-051aee5fa181',
                'contact_number' => 20,
                'created_at' => '2025-01-24 17:40:14',
                'updated_at' => '2025-01-24 17:40:14',
            ),
            20 =>
            array (
                'id' => 21,
                'merchant_id' => 21,
                'contact_id' => '437aaf97-2733-40df-b0b1-f90ddb2d236f',
                'contact_number' => 21,
                'created_at' => '2025-01-24 17:40:15',
                'updated_at' => '2025-01-24 17:40:15',
            ),
            21 =>
            array (
                'id' => 22,
                'merchant_id' => 22,
                'contact_id' => 'c5bc0e68-21f6-4552-a10e-7e8613b257b9',
                'contact_number' => 22,
                'created_at' => '2025-01-24 17:40:15',
                'updated_at' => '2025-01-24 17:40:15',
            ),
            22 =>
            array (
                'id' => 23,
                'merchant_id' => 23,
                'contact_id' => '4df9e7c1-ab3b-44b8-8bba-190a1fb490df',
                'contact_number' => 23,
                'created_at' => '2025-01-24 17:40:16',
                'updated_at' => '2025-01-24 17:40:16',
            ),
            23 =>
            array (
                'id' => 24,
                'merchant_id' => 24,
                'contact_id' => '7f0a06b2-6a91-4681-9d10-a234502a5e26',
                'contact_number' => 24,
                'created_at' => '2025-01-24 17:40:16',
                'updated_at' => '2025-01-24 17:40:16',
            ),
            24 =>
            array (
                'id' => 25,
                'merchant_id' => 25,
                'contact_id' => 'b2853b31-46ce-4415-98d0-a6893d435677',
                'contact_number' => 25,
                'created_at' => '2025-01-24 17:40:16',
                'updated_at' => '2025-01-24 17:40:16',
            ),
            25 =>
            array (
                'id' => 26,
                'merchant_id' => 26,
                'contact_id' => '4ad4b78f-8643-422e-9836-fdd62b9dffe0',
                'contact_number' => 26,
                'created_at' => '2025-01-24 17:40:17',
                'updated_at' => '2025-01-24 17:40:17',
            ),
            26 =>
            array (
                'id' => 27,
                'merchant_id' => 27,
                'contact_id' => '98f0ecb8-dbc8-4d80-a21c-e35316e2fea4',
                'contact_number' => 27,
                'created_at' => '2025-01-24 17:40:17',
                'updated_at' => '2025-01-24 17:40:17',
            ),
            27 =>
            array (
                'id' => 28,
                'merchant_id' => 28,
                'contact_id' => '539b2953-2a8b-4606-862e-d22e98e3cabd',
                'contact_number' => 28,
                'created_at' => '2025-01-24 17:40:18',
                'updated_at' => '2025-01-24 17:40:18',
            ),
            28 =>
            array (
                'id' => 29,
                'merchant_id' => 29,
                'contact_id' => '5381db3b-7690-4e01-b829-f7dcf539b4ba',
                'contact_number' => 29,
                'created_at' => '2025-01-24 17:40:18',
                'updated_at' => '2025-01-24 17:40:18',
            ),
            29 =>
            array (
                'id' => 30,
                'merchant_id' => 30,
                'contact_id' => 'cfe36d55-e764-4a10-98c0-0206ad059939',
                'contact_number' => 30,
                'created_at' => '2025-01-24 17:40:19',
                'updated_at' => '2025-01-24 17:40:19',
            ),
            30 =>
            array (
                'id' => 31,
                'merchant_id' => 31,
                'contact_id' => '8029cdf0-a450-4010-b95f-22c66edaabb9',
                'contact_number' => 31,
                'created_at' => '2025-01-24 17:40:19',
                'updated_at' => '2025-01-24 17:40:19',
            ),
            31 =>
            array (
                'id' => 32,
                'merchant_id' => 32,
                'contact_id' => '3ad3a723-ed59-4ee1-b5e1-06aaf5edf5b9',
                'contact_number' => 32,
                'created_at' => '2025-01-24 17:40:20',
                'updated_at' => '2025-01-24 17:40:20',
            ),
            32 =>
            array (
                'id' => 33,
                'merchant_id' => 33,
                'contact_id' => '93513049-24d0-43c4-8333-454c51fb570c',
                'contact_number' => 33,
                'created_at' => '2025-01-24 17:40:20',
                'updated_at' => '2025-01-24 17:40:20',
            ),
            33 =>
            array (
                'id' => 34,
                'merchant_id' => 34,
                'contact_id' => '56a18c67-3ef3-4196-adef-f0873f5340f1',
                'contact_number' => 34,
                'created_at' => '2025-01-24 17:40:21',
                'updated_at' => '2025-01-24 17:40:21',
            ),
            34 =>
            array (
                'id' => 35,
                'merchant_id' => 35,
                'contact_id' => '565a6d1b-187f-4757-9d83-c5c6d65ab6ac',
                'contact_number' => 35,
                'created_at' => '2025-01-24 17:40:21',
                'updated_at' => '2025-01-24 17:40:21',
            ),
            35 =>
            array (
                'id' => 36,
                'merchant_id' => 36,
                'contact_id' => '289708f3-36ce-407f-ab13-12a3f71b3382',
                'contact_number' => 36,
                'created_at' => '2025-01-24 17:40:22',
                'updated_at' => '2025-01-24 17:40:22',
            ),
            36 =>
            array (
                'id' => 37,
                'merchant_id' => 37,
                'contact_id' => '5621abd1-a136-432b-9f50-2fdf16d58e37',
                'contact_number' => 37,
                'created_at' => '2025-01-24 17:40:23',
                'updated_at' => '2025-01-24 17:40:23',
            ),
            37 =>
            array (
                'id' => 38,
                'merchant_id' => 38,
                'contact_id' => 'ce6bdbfe-cb1c-440a-8ab0-4980df9c35d9',
                'contact_number' => 38,
                'created_at' => '2025-01-24 17:40:24',
                'updated_at' => '2025-01-24 17:40:24',
            ),
            38 =>
            array (
                'id' => 39,
                'merchant_id' => 39,
                'contact_id' => '9591a1a8-943e-43b4-9dc8-78475d458e65',
                'contact_number' => 39,
                'created_at' => '2025-01-24 17:40:24',
                'updated_at' => '2025-01-24 17:40:24',
            ),
            39 =>
            array (
                'id' => 40,
                'merchant_id' => 40,
                'contact_id' => '47bd4673-bf2e-490f-9032-fb3e4d94abcd',
                'contact_number' => 40,
                'created_at' => '2025-01-24 17:40:25',
                'updated_at' => '2025-01-24 17:40:25',
            ),
            40 =>
            array (
                'id' => 41,
                'merchant_id' => 41,
                'contact_id' => '60123fe9-6e30-4678-ba19-2a95757e0520',
                'contact_number' => 41,
                'created_at' => '2025-01-24 17:40:25',
                'updated_at' => '2025-01-24 17:40:25',
            ),
        ));


    }
}
