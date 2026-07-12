<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ports', function (Blueprint $table) {

            $table->string('wpi_number')->nullable()->after('id');

            $table->string('country_code')->nullable();

            $table->string('harbor_size')->nullable();

            $table->string('harbor_type')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('ports', function (Blueprint $table) {

            $table->dropColumn([
                'wpi_number',
                'country_code',
                'harbor_size',
                'harbor_type'
            ]);

        });
    }
};
