<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CurrencySeeder extends Seeder
{
    /*protected function get_rate($from, $amount = 1, $to = 'HUF', $bypass = false)
    {
        $cacheKey = "{$from}_{$to}_{$amount}";
        $cachePath = storage_path("app/{$cacheKey}.json");
        $useCache = !$bypass && file_exists($cachePath) && filemtime($cachePath) >= strtotime('-1 week');

        if ($useCache) {
            $response = json_decode(file_get_contents($cachePath), true);
        } else {
            $response = Http::acceptJson()
                ->withHeaders([
                    "apikey" => "JFql0BSsajHPmliJ671Q1nZJbCBTOe69"
                ])
                ->get("http://api.apilayer.com/exchangerates_data/convert", [
                    'to' => $to,
                    'from' => $from,
                    'amount' => $amount,
                ])->json();

            // Save response data to cache file
            file_put_contents($cachePath, json_encode($response));
        }

        if (! isset($response['result'])) {
            throw new \RuntimeException('Exchange-rate API error: ' . json_encode($response));
        }

        return $response['result'];
    }*/


    public function run(): void
    {
        Currency::truncate();

        // Currency::create([
        //     "code" => 'USD',
        //     "sign" => '$',
        //     "name" => 'US Dollar',
        //     "exchange_rate" => 1,
        //     "default" => true,
        // ]);
        Currency::create([
            "code" => 'CLP',
            "sign" => '$',
            "name" => 'Chilean Peso',
            "exchange_rate" => 1,
            "default" => true,
        ]);

        /*$currencies = [
            [
                "code" => 'USD',
                "sign" => '$',
                "name" => 'US Dollar',
            ],
            [
                "code" => 'EUR',
                "sign" => '€',
                "name" => 'Euro',
            ],
            [
                "code" => 'GBP',
                "sign" => '£',
                "name" => 'British Pound',
            ],
            [
                "code" => 'BDT',
                "sign" => '৳',
                "name" => 'Bangladeshi Taka',
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::create(
                array_merge(
                    $currency,
                    ['exchange_rate' => 1]
                )
            );
        }

        foreach ($currencies as $currency) {
            Currency::create(
                array_merge(
                    $currency,
                    ['exchange_rate' => $this->get_rate($currency['code'], 1, 'HUF', true)]
                )
            );
        }*/
    }
}
