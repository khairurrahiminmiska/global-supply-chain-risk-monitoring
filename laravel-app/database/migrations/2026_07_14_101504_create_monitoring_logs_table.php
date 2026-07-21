<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('monitoring_logs', function (Blueprint $table) {
            $table->id();

            $table->string('type', 100)
                ->default('RISK_MONITORING');

            $table->string('status', 20);

            $table->unsignedInteger('total_countries')
                ->default(0);

            $table->unsignedInteger('success_count')
                ->default(0);

            $table->unsignedInteger('failed_count')
                ->default(0);

            $table->timestamp('started_at')
                ->nullable();

            $table->timestamp('completed_at')
                ->nullable();

            $table->unsignedBigInteger('duration_ms')
                ->default(0);

            $table->text('message')
                ->nullable();

            $table->timestamps();

            $table->index('type');
            $table->index('status');
            $table->index('started_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('monitoring_logs');
    }
};
