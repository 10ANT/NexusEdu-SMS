<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassDriveFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_drive_folders', function (Blueprint $table) {
            $table->id();
            $table->string('class_id');
            $table->string('folder_name');
            $table->string('folder_id');
            $table->string('folder_link');
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
        Schema::dropIfExists('class_drive_folders');
    }
}
