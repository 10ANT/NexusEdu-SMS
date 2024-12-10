<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteToEventsTable extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->softDeletes(); // This adds the deleted_at column
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}