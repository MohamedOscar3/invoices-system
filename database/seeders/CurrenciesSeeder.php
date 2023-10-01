<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrenciesSeeder extends Seeder
{
    public function run(): void
    {
        $currencyData = json_decode(file_get_contents(public_path('currencies.json')), true);

        foreach ($currencyData as $currency) {
            Currency::firstOrCreate([
                'title' => $currency['title'],
                'symbol' => $currency['symbol'],
            ]);

        }
    }
}
