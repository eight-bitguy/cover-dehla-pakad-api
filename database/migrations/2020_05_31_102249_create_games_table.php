<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('room_id');
            $table->json('a1');
            $table->json('a2');
            $table->json('b1');
            $table->json('b2');
            $table->json('stake');
            $table->json('score');
            $table->integer('dehla_on_stake')->default(0);
            $table->string('claming_by')->nullable();
            $table->string('trump')->nullable();
            $table->string('trump_from_next_iteration')->nullable();
            $table->string('trump_decided_by')->nullable();
            $table->string('played_by')->nullable();
            $table->string('next_chance')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
