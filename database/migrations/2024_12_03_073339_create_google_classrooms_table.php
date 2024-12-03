<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleClassroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_classrooms', function (Blueprint $table) {
            $table->id();
            $table->string('class_id');
            $table->string('course_id');
            $table->string('course_name');
            $table->string('course_link');
            $table->string('section');
            $table->string('room');
            $table->string('created_by');
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
        Schema::dropIfExists('google_classrooms');
    }
}
