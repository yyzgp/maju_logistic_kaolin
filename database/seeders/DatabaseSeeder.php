<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\XeroCredential;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(XeroCredentialSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(CountrySeeder::class);
        $this->Call(SingaporeLocationSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(AdministratorSeeder::class);
        $this->call(DriverSeeder::class);
        $this->call(MerchantSeeder::class);
        $this->call(VehicleTypeSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(TaskSeeder::class);

        // DB::table("xero_tokens")->insert([
        //     "tenant_id" => "320b56f2-4c66-46aa-93b0-2f61426054cd",
        //     "id_token"  => "eyJhbGciOiJSUzI1NiIsImtpZCI6IjFDQUY4RTY2NzcyRDZEQzAyOEQ2NzI2RkQwMjYxNTgxNTcwRUZDMTkiLCJ0eXAiOiJKV1QiLCJ4NXQiOiJISy1PWm5jdGJjQW8xbkp2MENZVmdWY09fQmsifQ.eyJuYmYiOjE3Mzc3MDg4OTksImV4cCI6MTczNzcwOTE5OSwiaXNzIjoiaHR0cHM6Ly9pZGVudGl0eS54ZXJvLmNvbSIsImF1ZCI6Ijk2QjA1Mjk5MjJFNjQ3QTZCMTVGMDJERUZBMkEyNzlEIiwiaWF0IjoxNzM3NzA4ODk5LCJhdF9oYXNoIjoieWtTZW1ZUHJCRzZoT2EtSzlJLUhNdyIsInNpZCI6IjkyOWFiNWMzOTFiNjRlMDVhY2UxOGY1NTQyMDk0M2M0Iiwic3ViIjoiNGUyZjg0MGM5OWVkNThkMzg1ZjkyZGE3NzkwMGMzMWQiLCJhdXRoX3RpbWUiOjE3Mzc3MDg4OTEsInhlcm9fdXNlcmlkIjoiOWE3MTYzMjctYjA1Mi00OTczLTkyNWEtYjQ1NWFlNDMwYzc1IiwiZ2xvYmFsX3Nlc3Npb25faWQiOiI5MjlhYjVjMzkxYjY0ZTA1YWNlMThmNTU0MjA5NDNjNCIsInByZWZlcnJlZF91c2VybmFtZSI6ImdyaWRwbHVzLmRldmVsb3BlckBnbWFpbC5jb20iLCJlbWFpbCI6ImdyaWRwbHVzLmRldmVsb3BlckBnbWFpbC5jb20iLCJnaXZlbl9uYW1lIjoiR3JpZCIsImZhbWlseV9uYW1lIjoiUGx1cyIsIm5hbWUiOiJHcmlkIFBsdXMiLCJhbXIiOlsibGVnYWN5Il19.lguCdfYBJ010DEb4RdHyD5gWgyiFu5IUBjPe-UtT-pCT3cynHm_f0JzFR4_2srGB9dCA319u8mskfSQb0Y3iOjFAb1kyZHGSh7acLJob7vH2Zs1FRgs8ld4ivh6ATDjuCNbXlDmELkoNW8mUfmlBwKER-1K9jZm0jpy4jYKlTTR3gmWV6esL-5T87CqUJwbhxFENwHdBRKHMf1R-HP65s_8jW2Zdo48bQxsO4cGBHxZe7Ditgr94I3q_LS6E3fmg1qW7HoWtWg9qupgITg-lcDz3k6XUb90JTZ-q0ZsKjQEGg7Uv0iPBO3_XzIA-lJbh_PSh5144_0bJaClvj_vXlA",
        //     "access_token" => "eyJpdiI6Ikh4Qll2WjFZY0RldFhRVlZ1bWVmNFE9PSIsInZhbHVlIjoiSzdodmVxdE43SXNUdXd5bjFxT0lIS29JL3ZxN1JaR2ZrNHpYWkNxbURxL0pZN1RoS2dmMkgxQzFYaHEvd25PcXJ3Q29qclhJV2pJbW9Ka1VLYk5oOWZQcmQ0dmZDM3NHbjUxS3A1MCtWKzRTMlNDZ3AxYzlMVlA1ZlhSbGpHSmh0blcvK285VDlNUWYyVCtOckV0WEdPaWZDUlhUdmp3am5pMXl0djlqUWJLTmphV1IyNnRVZVpxMEFCNVhHVkk4T2tHN3plREZhWHRlSDgvUHFNTDRXU0l5K2NyMW1CZkV1dGRLd0dXVGxtQjlYL09mMEVyNmJYRHVNaUpqNTk4OXdUSWdLVmJxN0Yrak94WW1tM0FqS2JGeFZVc2pSdmdXa0lBeHN2MWJ6WXhLV0tRZm9zT2crUWJmNFZvdk9ld3R4ZHRpM3ZOT0xuM0lLeEJxVmh5N3dNcFpQSjBWYXlZUERQZ0RJTjFGd0dZZmF0emM2YjBLeGFYdS9PUHdoUXNHcG9xUG0rcDJWVGphVWdvQVdYVE81QW93Nkg0Z2R0S1NjdW9SOGI5anFJS004cDh4dE04VzVrcnZQRUtFclJPZ2ZzUFlYTlBVU2ZqbExUeURPQmpJY2RaVXlwd1k3QkJzUGkvZEtaTDc2ay8vVmJFNU1abTNaRmtLVlBvR04zc29ZaVRxKytMTEZoR2RIcG51K25OMkRBaTllRU5QS3VwSEdvWjdWTUhsRURFN0xFNVpRYjEvOGZqTitzMERKcFE2MkZ3RWdZNlVWaWVWeHVzTlhxcURUT292L3RzR3FpVkdMQWt5REtOR0RGbG9MSHRUWStMY3RwVjNBUzQ1TUg0c1dKNDBBU1M3MFF1VVhLZDllNFBqWC9OL1lYeEhqYWRVUnN3Z2JSdFVHSlJUNjhvSHUxTnpDdDdqUWxVNUpsejgvN2cya0NlQjE5WmNQSTFINDc1bGdqZytzVWgrMjZ6ZFRoZURBRmpHZktUdWZHb1RnUGp5TDd0bXRLcXU5NStDTGVJVVBJaDhKelIvTC93Nmtack9wUFJhR05lai8xL3k2TDBLNXB6UkNRSGNhMHlrbGY4TEt4bm0rOTVoWFBUYkpVQ29CVDBIMjZyUSt0TThBdExTUlNNQVVlcWY3aUl2SWFmNXQwYXlEZDJBZG5zNmZWcFZ5amc4cVJkeUx6N00zVWpEeDBZZ3NHQnVqQzZCL3Z1WXlJVHhIWEdOVGExa2JUdmNLUmFpR1NGV2xZNkxwcUg3RnpUaU81dEdiQm11bnBsTUlSRzR3WjlCYTFSRTluVXA3ZlpBSFZnU0ExMFRUVlp5Zk9yRUxQUG1KYTArbCs2TWJzUVBBcUhvSzlVbTEvWGt3VzNpYnF0eGNRVEVIKytrUlRab0ZEOE95OVgyMEsxNmlpTzd1M2VoNG10VWtxWUcreG9HZHB2c05IUmtLT2NwanRsU1ROdTMzdFFBb0dTRDA0NDRZcE4zV1l3YXpUNDBDeDdxRCtoVTlyUDJQYmx5RkUrVGRibDY1YUhpaGx6a0QxOE1tMmovTmMwN28xNENxcTJrVFVRTkRPemtOZ3ZmYjhwa3czdTFRcDlNd0o4dUwzZ28zK0wyZDlFT0Q2eDJPYVd0dFV1cmNWeTk3RnJLUnlxWmJTQWRiUzFPRm4vQXI3MnQ2OUd4R3pFTjljeXdSb0RPZGZORXlnRmZwZ2w3di8zWmtuVXp3WUtxWjNZY0U3NVlaa1NEMWxyRGlVVTRDaThRQjdMTE5vYUh1ZHpNN21jb2xnei9NSVpNYzBWRDVTWmFuWVREZUx1ZmJ0TjEvNFBwVkZTZUMzZVpCTVBBdGJwUzRGdEdOMDlNV1ZoUDgzVDNDekFDUmhOZzhqM1pNMXdXZTFCSUJHWVhLbnNDeHZuclljRW5Ec05vRE1ZL3hqL2h3YXZQQkJQMnl1OVNTbFowUC9hNTRKNjNadUZndlBNRThxc2p1VkpDY1RkdlRXMGxiK0RpZFVaWlJBLzNuMUlGOHZsVytGV1dYckNmcXMxYSsvVW05MkJ1QUgrK3ZTMTkrSVJIOUhsYmxPVlI5N0J3RktsLzdiSG5oTHhlbDBOcWpTb3FxSkxoTm1NSjUrQTk0Ty9SZ2hpSFhzZFhObFFHazUwWVN1WHplQ0J1Q0pHeXJ2WE9vZS9NVmRmeE04ZVlsTWFURDBmNHRNWHpqa3V4eXVSdkxFVFg2U3l1T2V1S0hNNXUyOHkrdTZaZTYvS3dVYVBEd1BTOCtOc280WUJ4cGNiemNraVhoamZ4OUtiT1YrcHNIY1ZYVkdjOHhUQkI4RmI0WU5Pd0c5Zjd2by9hMitRb3ptalF1V3NqMkZwRkY1dz0iLCJtYWMiOiIwMDBjOWIwMDA4OTZhOThhOWUzODExNWU3MGQwY2Y1NjU5MTUwMmE3MDY5MDAxYTE3ZTNlMmJkNzVmZjhjNWQzIiwidGFnIjoiIn0=",
        //     "expires_in" => "1800",
        //     "token_type" => "Bearer",
        //     "refresh_token" => "eyJpdiI6Im1QZFRoU1VqNHM0K0h5UmFLRWJzS3c9PSIsInZhbHVlIjoic0VhOEJYdGllUTZvdlF4OVl5NkpiMUF4c1hTcVp6ZElwUm1FVXZyWGMwVExTSk94RW1EVW4zM09MYlpMdC9HRCIsIm1hYyI6ImU4ZjE2ZWUxMDAxMGIzYTRmNWQzMTdlOGZkOGViZWRmZjQ0NmRlYzA5NzM0MmQ2NzU1OThmZDFlZDE1ZTc4ODQiLCJ0YWciOiIifQ==",
        //     "scopes" => "openid email profile accounting.settings accounting.transactions accounting.contacts offline_access",
        //     "updated_at" => "2025-01-24 16:55:00",
        //     "created_at" => "2025-01-24 16:55:00",
        // ]);
        $this->call(MerchantXeroCredentialSeeder::class);
    }
}
