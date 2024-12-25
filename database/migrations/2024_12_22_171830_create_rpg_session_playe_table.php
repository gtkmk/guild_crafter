<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rpg_session_player', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->smallInteger('assigned_guild')->nullable();
            $table->uuid('rpg_session_id');
            $table->uuid('player_id');
            $table->timestamps();
            $table->foreign('rpg_session_id')->references('id')->on('rpg_session')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
            $table->unique(['rpg_session_id', 'player_id']);
        });
    }

    public function down(): void
    {
        Schema::table('rpg_session_player', function (Blueprint $table) {
            $table->dropForeign(['rpg_session_id']);
            $table->dropForeign(['player_id']);
        });

        Schema::dropIfExists('rpg_session_player');
    }
};
