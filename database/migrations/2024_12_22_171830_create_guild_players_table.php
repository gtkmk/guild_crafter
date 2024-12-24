<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guild_player', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('guild_id');
            $table->uuid('player_id');
            $table->foreign('guild_id')->references('id')->on('guilds')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('guild_player', function (Blueprint $table) {
            $table->dropForeign(['guild_id']);
            $table->dropForeign(['player_id']);
        });

        Schema::dropIfExists('guild_player');
    }
};
