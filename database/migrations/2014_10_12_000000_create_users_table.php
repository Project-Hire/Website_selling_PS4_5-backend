<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->string('gender');
            $table->string('birth');
            $table->string('number_phone');
            $table->boolean('role');
            $table->string('address');
            $table->string('email')->unique()->default(NULL);
            $table->boolean('confirm');
            $table->string('confirmation_code')->default(NULL);
            $table->dateTime('confirmation_code_expired_in')->default(NULL);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
