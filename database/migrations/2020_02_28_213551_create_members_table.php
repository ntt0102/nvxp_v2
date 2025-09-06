<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('pedigree');
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedSmallInteger('ordinal_brother')->nullable();
            $table->unsignedInteger('couple_id')->nullable();
            $table->unsignedSmallInteger('marriage_step')->nullable();
            $table->string('name');
            $table->string('gender')->nullable();
            $table->text('note')->nullable();
            $table->boolean('upperFlag')->default(0);
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
        Schema::dropIfExists('members');
    }
}
