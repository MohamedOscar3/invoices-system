<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceStatusSeeder extends Seeder
{
    public function run()
    {
        DB::table('invoice_status')->insert([
            ['title' => 'pending'],
            ['title' => 'paid'],
            ['title' => 'canceled'],
        ]);
    }
}
