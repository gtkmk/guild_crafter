<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rpg_session', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->length(100);
            $table->date('campaign_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rpg_session');
    }
};
