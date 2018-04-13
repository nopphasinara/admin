<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelHasPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('model_has_permissions', function (Blueprint $table) {
          $table->integer('permission_id')->unsigned();
          $table->morphs('model');

          $table->foreign('permission_id')
              ->references('id')
              ->on('permissions')
              ->onDelete('cascade');

          $table->primary(['permission_id', 'model_id', 'model_type']);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_has_permissions');
    }
}
