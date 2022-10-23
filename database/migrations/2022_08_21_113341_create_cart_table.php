<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cd_games_id')->unsigned()->index()->nullable();
            $table->foreign('cd_games_id')->references('id')->on('cd_games')->onDelete('cascade');
            $table->bigInteger('gift_card_id')->unsigned()->index()->nullable();
            $table->foreign('gift_card_id')->references('id')->on('gift_card')->onDelete('cascade');
            $table->bigInteger('accessory_id')->unsigned()->index()->nullable();
            $table->foreign('accessory_id')->references('id')->on('accessory')->onDelete('cascade');
            $table->bigInteger('game_console_id')->unsigned()->index()->nullable();
            $table->foreign('game_console_id')->references('id')->on('game_console')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('money');
            $table->integer('quantity');
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
        Schema::dropIfExists('cart');
    }
}
