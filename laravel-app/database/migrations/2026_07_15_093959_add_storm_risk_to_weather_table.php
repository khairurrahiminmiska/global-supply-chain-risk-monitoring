<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weather', function (Blueprint $table) {
            $table->string('storm_risk', 20)
                ->default('LOW')
                ->after('weather_code');
        });
    }

    public function down(): void
    {
        Schema::table('weather', function (Blueprint $table) {
            $table->dropColumn('storm_risk');
        });
    }
};