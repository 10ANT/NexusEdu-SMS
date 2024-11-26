<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParishesTable extends Migration
{
    public function up()
    {
        Schema::create('parishes', function (Blueprint $table) {
            $table->id(); // Automatically creates an ID field
            $table->string('name'); // To store the parish name
            //$table->unsignedBigInteger('region_id'); // Foreign key for region
            $table->timestamps(); // Created and updated timestamps
            
            // Adding the foreign key constraint
            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('parishes');
    }
}
