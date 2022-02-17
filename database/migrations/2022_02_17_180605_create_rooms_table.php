<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250)->nullable();
            $table->integer( 'building_id')->nullable();
            $table->integer( 'floor_id')->nullable();
            $table->integer( 'number_of_people')->nullable();
            $table->integer( 'price')->nullable()->comment("1: Sub_type_one | 2: Sub_type_two");;
            $table->integer('acreage_m2')->nullable();
            $table->integer('deposit')->nullable();
            $table->date('date_empty')->nullable();
            $table->integer('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rooms');
    }
}
