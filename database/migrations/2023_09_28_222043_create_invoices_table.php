<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->bigInteger('invoice_status_id')->unsigned()->default(1);
            $table->foreign('invoice_status_id')->references('id')->on('invoice_statuses')->onDelete('cascade');
            $table->float('total');
            $table->bigInteger('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('invoice_totals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['fixed', 'percentage']);
            $table->double('price');
            $table->bigInteger('invoice_id')->unsigned();
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_totals');
        Schema::dropIfExists('invoices');
    }
};
