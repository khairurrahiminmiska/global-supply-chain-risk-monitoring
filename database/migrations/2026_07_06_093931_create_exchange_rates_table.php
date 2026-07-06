<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exchange_rates', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('base_currency');

            $table->string('target_currency');

            $table->decimal('rate',12,4);

            $table->timestamp('retrieved_at');

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};