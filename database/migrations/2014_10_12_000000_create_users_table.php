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
           $table->string('name');
           $table->string('username')->unique()->nullable();
        //    $table->string('username')->unique()->nullable();
           $table->string('email')->unique();
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



// public function up()
// {
//     Schema::create('users', function (Blueprint $table) {
//        $table->bigIncrements('id');
//        $table->string('fname');
//        $table->string('lname');
//        $table->string('phone');
//        $table->string('email')->unique();
//        $table->timestamp('email_verified_at')->nullable();
//        $table->string('password');
//        $table->rememberToken();
//        $table->timestamps();
//    });
// }
