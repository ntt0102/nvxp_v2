<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassifiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classifies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('constant_id');
            $table->string('name');
            $table->string('value');
            $table->unsignedSmallInteger('display_no');
            $table->timestamps();
            $table->unsignedInteger('modified_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classifies');
    }
}
