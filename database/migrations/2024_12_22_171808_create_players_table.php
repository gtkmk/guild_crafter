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
        Schema::create('players', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->enum('class', ['Guerreiro', 'Mago', 'Arqueiro', 'Clérigo']);
            $table->integer('xp')->unsigned()->default(1)->comment('Experience points (1-100)');
            $table->boolean('is_confirmed')->default(false)->comment('Player confirmation for session');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
