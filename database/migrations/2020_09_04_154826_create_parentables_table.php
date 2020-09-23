<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParentablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('parentables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('relation')->default('Père');
            $table->boolean('ability')->default(false);
            $table->unsignedBigInteger('parentor_id');
            $table->foreign('parentor_id')
                  ->references('id')
                  ->on('parentors')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->unsignedBigInteger('pupil_id');
            $table->foreign('pupil_id')
                  ->references('id')
                  ->on('pupils')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
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
        Schema::dropIfExists('parentables');
    }
}
