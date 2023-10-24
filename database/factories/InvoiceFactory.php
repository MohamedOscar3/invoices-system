<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Invoice;
use App\Models\InvoiceStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(),
            'total' => $this->faker->randomFloat("2", 0, 1000),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'invoice_status_id' => 1,
            'currency_id' => 8,

        ];
    }
}
