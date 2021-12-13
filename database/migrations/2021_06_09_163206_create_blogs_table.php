<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250)->nullable();
            $table->string( 'slug', 250)->nullable();
            $table->integer( 'parent_id')->nullable();
            $table->integer( 'type')->nullable()->comment("1: Type_one | 2: Type_two");;
            $table->integer( 'sub_type')->nullable()->comment("1: Sub_type_one | 2: Sub_type_two");;
            $table->longText('content')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('blogs');
    }
}
