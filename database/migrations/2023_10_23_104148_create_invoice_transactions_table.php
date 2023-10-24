<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoice_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Invoice::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\InvoiceStatus::class)->constrained()->onDelete('cascade');
            $table->enum('request_type',["callback","redirect"]);
            $table->string('tran_ref')->nullable();
            $table->string('tran_type')->nullable();
            $table->json('payment_info')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_transactions');
    }
};
