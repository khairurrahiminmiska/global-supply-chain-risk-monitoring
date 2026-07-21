<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('country_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->integer('weather_score')->default(0);
            $table->integer('inflation_score')->default(0);
            $table->integer('currency_score')->default(0);
            $table->integer('news_score')->default(0);
            $table->integer('port_score')->default(0);

            $table->integer('total_score')->default(0);

            $table->string('risk_level', 20);

            $table->timestamp('calculated_at');

            $table->timestamps();

            $table->index(['country_id', 'calculated_at']);
            $table->index('risk_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_histories');
    }
};


