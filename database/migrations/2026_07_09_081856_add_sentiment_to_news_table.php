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
    Schema::table('news', function (Blueprint $table) {

        $table->integer('positive_score')->default(0);

        $table->integer('negative_score')->default(0);

        $table->string('sentiment')->default('Neutral');

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('news', function (Blueprint $table) {

        $table->dropColumn([
            'positive_score',
            'negative_score',
            'sentiment'
        ]);

    });
}
};
