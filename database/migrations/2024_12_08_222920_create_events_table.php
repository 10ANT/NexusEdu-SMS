<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   // database/migrations/xxxx_xx_xx_create_events_table.php
   public function up()
   {
       Schema::create('events', function (Blueprint $table) {
           $table->id();
           $table->string('title');
           $table->dateTime('start');
           $table->dateTime('end');
           $table->text('description')->nullable();
           $table->string('color')->default('#3788d8');
           $table->unsignedInteger('user_id');
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('events');
    }
}
