<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelHasRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('model_has_roles', function (Blueprint $table) {
          $table->integer('role_id')->unsigned();
          $table->morphs('model');

          $table->foreign('role_id')
              ->references('id')
              ->on('roles')
              ->onDelete('cascade');

          $table->primary(['role_id', 'model_id', 'model_type']);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_has_roles');
    }
}
