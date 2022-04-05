<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWater extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('waters', function (Blueprint $table) {
            $table->integer('room_id');
            $table->date('date');
            $table->integer('old_number');
            $table->integer('new_number');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('waters', function (Blueprint $table) {
            //
        });
    }
}
