<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
         Schema::create('horaires', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('day');
            $table->string('start');
            $table->string('end');
            $table->string('creator')->nullable();
            $table->string('editor')->nullable();
            $table->unsignedBigInteger('year')->nullable();

            $table->unsignedBigInteger('classe_id');
            $table->foreign('classe_id')
                  ->references('id')
                  ->on('classes')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')
                  ->references('id')
                  ->on('subjects')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
       
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
        Schema::dropIfExists('horaires');
    }
}
