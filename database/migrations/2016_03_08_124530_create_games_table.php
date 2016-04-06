<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            // $table->string('player1')->nullable();
            // $table->string('player2')->nullable();
            // upgrade to 4players
            // $table->string('player3')->nullable();
            // $table->string('player4')->nullable();
            $table->integer('points_left')->default(0);
            $table->integer('points_right')->default(0);
            $table->boolean('winner')->nullable();
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
        Schema::drop('games');
    }
}
