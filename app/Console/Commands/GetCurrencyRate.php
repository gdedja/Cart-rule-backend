<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\CurrencyRate;

class GetCurrencyRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:currencyrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the currency rate';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response = Http::get('https://api.currencyapi.com/v3/latest', [
            'apikey' => 'cur_live_5Kmdg16tqC4PO1hsBXC0zvxg9tNT7veedwnY525F'
        ]);

        if ($response->successful()) {
            $currencies = $response->json();

            $dkk = $currencies['data']['DKK']['value'];
            $eur = $currencies['data']['EUR']['value'];
            $gbp = $currencies['data']['GBP']['value'];

            // Insert new record into the database
            CurrencyRate::create([
                'DKK' => $dkk,
                'EUR' => $eur,
                'GBP' => $gbp
            ]);

            $this->info('Currency rates have been added.');
        } else {
            $this->error('Failed to fetch currencies data.');
        }
    }
}
