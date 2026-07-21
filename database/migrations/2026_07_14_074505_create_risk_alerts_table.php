<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_alerts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete();

            $table->foreignId('risk_score_id')
                ->nullable()
                ->constrained('risk_scores')
                ->nullOnDelete();

            $table->string('type');

            $table->string('level');

            $table->string('title');

            $table->text('message');

            $table->decimal('risk_score', 5, 2)
                ->nullable();

            $table->boolean('is_read')
                ->default(false);

            $table->timestamp('triggered_at');

            $table->timestamps();

            $table->index([
                'level',
                'is_read',
            ]);

            $table->index('triggered_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_alerts');
    }
};