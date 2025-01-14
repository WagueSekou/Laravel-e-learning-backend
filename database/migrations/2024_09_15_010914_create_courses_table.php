<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            //who is posting what
            $table->string('user_token', 50);
            $table->string('name', 200);
            $table->string('thubnail', 150);
            $table->string('video', 150)->nullable;
            $table->text('description',)->nullable;
            $table->smallInteger('type_id',);
            $table->float('price');
            $table->smallInteger('lesson_num')->nullable;//number of lesson which a user can recieve
            $table->Integer('video_length')->nullable;
            $table->smallInteger('follow')->nullable;
            $table->float('score')->nullable;

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
        Schema::dropIfExists('courses');
    }
}
