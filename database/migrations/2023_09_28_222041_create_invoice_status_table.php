<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceStatusTable extends Migration
{
    public function up()
    {
        Schema::create('invoice_status', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });

        // Seed the initial statuses
        DB::table('invoice_status')->insert([
            ['title' => 'pending'],
            ['title' => 'paid'],
            ['title' => 'canceled'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('invoice_status');
    }
}
