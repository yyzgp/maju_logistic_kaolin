<?php

namespace App\Console\Commands\Xero;

use App\Models\XeroCredential;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class Authenticate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:authenticate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $xero_credential = XeroCredential::first();


    }
}
